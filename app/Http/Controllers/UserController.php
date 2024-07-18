<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\MenstruationPeriod;

use Carbon\Carbon;

class UserController extends Controller
{

    public function index()
    {

        $menstruation_period_list = $this->getMenstruationPeriods();
        $estimated_next_period = null;
        if (count($menstruation_period_list) !== 0) {
            $estimated_next_period = $this->estimatedNextPeriod($menstruation_period_list->first()->menstruation_date, Auth::user()->birthdate);
        }

        return view('user.dashboard', compact('menstruation_period_list', 'estimated_next_period'));
    }

    public function menstruationCalendarPeriod()
    {

        $menstruation_period_list = $this->getMenstruationPeriods();
        if (count($menstruation_period_list) !== 0) {
            $estimated_next_period = $this->estimatedNextPeriod($menstruation_period_list->first()->menstruation_date, Auth::user()->birthdate);
        }

        return response()->json([
            'menstruation_period_list' => $menstruation_period_list,
            'estimated_next_period' => $estimated_next_period ?? null
        ]);
    }

    public function postMenstruationPeriod(Request $request)
    {
        try {
            if (Auth::check() && Auth::user()->id == $request->id) {

                if (Auth::user()->menstruation_status == 0) return response()->json(['status' => 'error', 'message' => 'Your menstruation status is inactive, you\'re not allowed to save new record at the moment.'], 500);

                $menstruation_period = MenstruationPeriod::firstOrCreate([
                    'user_id' => $request->id,
                    'menstruation_date' => date('Y-m-d', strtotime($request->menstruation_period)),
                ], [
                    'remarks' => $request->remarks
                ]);

                $menstruation_period_list = $this->getMenstruationPeriods();
                $estimated_next_period = $this->estimatedNextPeriod($menstruation_period_list->first()->menstruation_date, Auth::user()->birthdate);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Menstruation Period successfully added',
                    'period_date' => date('Y-m-d', strtotime($request->menstruation_period)),
                    'menstruation_period_list' => $menstruation_period_list->take(5),
                    'menstruation_period_count' => count($menstruation_period_list),
                    'latest_period_date' => date('F j, Y', strtotime($this->getMenstruationPeriods()->first()->menstruation_date)),
                    'estimated_next_period' => $estimated_next_period ? date('F j, Y', strtotime($estimated_next_period)) : null
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }

    public function updateMenstruationPeriod(Request $request)
    {
        try {
            if (Auth::check() && Auth::user()->id == $request->id) {

                if (Auth::user()->menstruation_status == 0) return response()->json(['status' => 'error', 'message' => 'Your menstruation status is inactive, you\'re not allowed to save new record at the moment.'], 500);

                $post_update_period = MenstruationPeriod::findOrfail($request->menstruation_period_id);
                $post_update_period->menstruation_date = date('Y-m-d', strtotime($request->menstruation_period));
                $post_update_period->remarks = $request->remarks ?? null;
                $post_update_period->save();

                return response()->json(['status' => 'success', 'message' => 'Menstruation Period successfully updated']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }

    public function deleteMenstruationPeriod(Request $request)
    {
        try {
            $post_delete_period = MenstruationPeriod::findOrfail($request->id);
            $post_delete_period->delete();

            return response()->json(['status' => 'success', 'message' => 'Menstruation Period successfully deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }

    public function menstrualIndex()
    {
        return view('user/menstrual/index');
    }

    public function menstrualData()
    {

        $menstruation_period_arr = $this->getMenstruationPeriods()->toArray();

        $row_count = 0;
        foreach ($menstruation_period_arr as $menstruation_period_key => $menstruation_period) {

            $menstruation_period_arr[$menstruation_period_key]['row_count'] = ++$row_count;
            $menstruation_period_arr[$menstruation_period_key]['menstruation_date'] = date('F j, Y', strtotime($menstruation_period['menstruation_date']));
            $menstruation_period_arr[$menstruation_period_key]['remarks'] = $menstruation_period['remarks'] ?? '<span class="text-muted small font-italic">N/A</span>';
            $menstruation_period_arr[$menstruation_period_key]['action'] = '
                <button type="button" class="btn btn-sm btn-primary edit_menstrual"
                    data-id="' . $menstruation_period['id'] . '"
                    data-menstruation_period="' . date('m/d/Y', strtotime($menstruation_period['menstruation_date'])) . '"
                    data-remarks="' . $menstruation_period['remarks'] . '">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>

                <button type="button" class="btn btn-sm btn-danger delete_menstrual" data-id="' . $menstruation_period['id'] . '"><i class="fa-solid fa-trash"></i> Delete</button>
            ';
        }

        return response()->json(['data' => $menstruation_period_arr, "recordsFiltered" => count($menstruation_period_arr), 'recordsTotal' => count($menstruation_period_arr)]);
    }

    public function profileIndex()
    {

        if (!Auth::check()) {
            Session::flash('auth-error', 'Please login to continue.');
            return redirect()->route('login.page');
        }

        try {
            $user = User::findOrFail(Auth::user()->id);
            return view('user/profile/index', compact('user'));
        } catch (ModelNotFoundException $e) {
            Session::flash('auth-error', 'Please login to continue.');
            return redirect()->route('login.page');
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $check_validation = Validator::make($request->all(), [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'nullable|email|max:100|unique:users,email',
                'menstruation_status' => 'required|boolean',
                'birthdate' => 'required|date|before:today',
                'contact_no' => ['numeric', 'nullable', 'regex:/^\d{10,11}$/', 'unique:users,contact_no', 'required_if:email,null'],
            ], [
                'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
                'contact_no.unique' => 'The contact number has already been taken.',
                'unique' => 'The :attribute field has already been taken.'
            ]);

            if ($check_validation->fails()) return response()->json(['success' => false, 'message' => $check_validation->errors()->first()], 500);

            if (!isset($request->id) || Auth::user()->id != $request->id) {
                return response()->json(['success' => false, 'message' => 'Something went wrong, failed to save data. Please try again.'], 500);
            }

            $user_data = User::findOrFail($request->id);
            $user_data->fill([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name ?? null,
                'last_name' => $request->last_name,
                'email' => $request->email ?? null,
                'contact_no' => $request->contact_no ?? null,
                'address' => $request->address ?? null,
                'birthdate' => date('Y-m-d', strtotime($request->birthdate)),
                'menstruation_status' => $request->menstruation_status ?? null,
                'remarks' => $request->remarks ?? null,
            ]);
            $user_data->save();

            return response()->json(['success' => true, 'message' => 'Profile successfully updated'], 200);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found, please refresh your browser and try again'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $check_validation = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|confirmed|min:6',
                'new_password_confirmation' => 'required|min:6'
            ]);

            if ($check_validation->fails()) return response()->json(['success' => false, 'message' => 'Something went wrong, failed to save data. Please try again.'], 500);

            if (!isset($request->id)) return response()->json(['success' => false, 'message' => 'Something went wrong, failed to save data. Please try again.'], 500);

            if (Auth::user()->id != $request->id) return response()->json(['success' => false, 'message' => 'Something went wrong, failed to save data. Please try again.'], 500);

            $user_data = User::findOrFail($request->id);

            if (!Hash::check($request->old_password, $user_data->password)) return response()->json(['success' => false, 'message' => 'Old password is incorrect, please try again.'], 500);

            $user_data->fill(['password' => Hash::make($request->new_password)]);
            $user_data->save();

            return response()->json(['success' => true, 'message' => 'Password successfully updated'], 200);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found, please refresh your browser and try again'], 404);
        }
    }

    private function getMenstruationPeriods()
    {
        $user = User::findOrFail(Auth::user()->id);
        $menstruation_period_list = $user->last_periods()->get();

        return $menstruation_period_list;
    }

    private function estimatedNextPeriod($last_period_date, $birthdate)
    {
        $last_period = Carbon::parse($last_period_date);
        $birthday = Carbon::parse($birthdate);

        $age = $last_period->diffInYears($birthday);

        // Set the average menstrual cycle length based on the age
        $average_cycle_length = $this->getAverageCycleLengthByAge($age);

        // Estimate the next period by adding the average menstrual cycle length
        $nextPeriod = $last_period->copy()->addDays($average_cycle_length);

        return $nextPeriod->toDateString();
    }

    private function getAverageCycleLengthByAge($age)
    {

        // average cycle lengths for different age ranges
        $average_cycle_lengths = [
            ['ageRange' => [12, 17], 'cycleLength' => 28],
            ['ageRange' => [18, 24], 'cycleLength' => 30],
            ['ageRange' => [25, 35], 'cycleLength' => 32],
            ['ageRange' => [36, 45], 'cycleLength' => 34],
            ['ageRange' => [46, PHP_INT_MAX], 'cycleLength' => 35],
        ];

        foreach ($average_cycle_lengths as $entry) {
            if ($age >= $entry['ageRange'][0] && $age <= $entry['ageRange'][1]) {
                return $entry['cycleLength'];
            }
        }

        return 28; // default cycle length if age range not found
    }
}
