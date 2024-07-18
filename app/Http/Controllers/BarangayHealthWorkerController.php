<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Traits\UserRegistrationTrait;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\MenstruationPeriod;
use App\Models\FeminineHealthWorkerGroup;
use Carbon\Carbon;

class BarangayHealthWorkerController extends Controller
{
    use UserRegistrationTrait;

    public function index()
    {
        $new_period_notification = $this->newMenstrualPeriodNotificationForHealthWorker();

        $assign_feminine_count = FeminineHealthWorkerGroup::where('health_worker_id', Auth::user()->id)->count();
        $count = $this->healthWorkerFeminineCount();

        return view('health_worker.dashboard', compact('assign_feminine_count', 'count', 'new_period_notification'));
    }

    public function feminineList()
    {
        $new_period_notification = $this->newMenstrualPeriodNotificationForHealthWorker();
        return view('health_worker.feminine.index', compact('new_period_notification'));
    }

    public function postFeminine(Request $request)
    {
        return $this->postForm($request->all());
    }

    public function deleteFeminie(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            if ($user) {
                $remove_assigned_feminine = FeminineHealthWorkerGroup::where('feminine_id', $user->id)
                    ->where('health_worker_id', Auth::user()->id)
                    ->delete();
            }

            return response()->json(['status' => 'success', 'message' => 'Feminine successfully removed.']);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function feminineData()
    {

        $feminine_arr = FeminineHealthWorkerGroup::join('users', 'users.id', '=', 'feminine_health_worker_groups.feminine_id')
            ->where('feminine_health_worker_groups.health_worker_id', Auth::user()->id)
            ->where('users.user_role_id', 2)
            ->orderBy('users.last_name', 'ASC')
            ->get(['users.id', 'users.first_name', 'users.last_name', 'users.middle_name', 'users.address', 'users.email', 'users.contact_no', 'users.birthdate', 'users.menstruation_status', 'users.is_active', 'users.remarks'])
            ->toArray();

        $row_count = 0;
        foreach ($feminine_arr as $feminine_key => $feminine) {
            $full_name = $feminine['last_name'] . ', ' . $feminine['first_name'] . ' ' . $feminine['middle_name'];
            $last_period_list = MenstruationPeriod::where('user_id', $feminine['id'])->orderBy('menstruation_date', 'DESC')->take(3)->get(['id', 'menstruation_date']);

            if (count($last_period_list) !== 0) {
                $estimated_next_period = $this->estimatedNextPeriod($last_period_list->first()->menstruation_date, $feminine['birthdate']);
            }

            $feminine_arr[$feminine_key]['row_count'] = ++$row_count;
            $feminine_arr[$feminine_key]['full_name'] = $full_name;
            $feminine_arr[$feminine_key]['menstruation_status'] = '<span class="text-' . ($feminine['menstruation_status'] === 1 ? 'success' : 'danger') . '"><strong>&bull;</strong> ' . ($feminine['menstruation_status'] === 1 ? 'Active' : 'Inactive') . '</span>';

            if ($feminine['is_active'] === 1) {
                $feminine_arr[$feminine_key]['is_active'] = '<span class="text-success"><strong>&bull;</strong> Verified</span>';
            } else {
                $feminine_arr[$feminine_key]['is_active'] = '<span class="text-warning"><strong>&bull;</strong> Pending</span>';
            }

            $feminine_arr[$feminine_key]['action'] = '
                <button type="button" class="btn btn-sm btn-secondary" id="period_notif_' . $feminine['id'] . '"
                    data-full_name="' . $full_name . '"
                    data-email="' . ($feminine['email'] ?? 'N/A' ) . '"
                    data-contact_no="' . $feminine['contact_no'] . '"
                    data-address="' . $feminine['address'] . '"
                    data-birthdate="' . ($feminine['birthdate'] ? date('F j, Y', strtotime($feminine['birthdate'])) : 'N/A') . '"
                    data-menstruation_status="' . $feminine['menstruation_status'] . '"
                    data-is_active="' . $feminine['is_active'] . '"
                    data-remarks="' . ($feminine['remarks'] ?? 'N/A') . '"
                    data-last_period_dates=' . (json_encode($last_period_list) ?? 'N/A') . '
                    data-estimated_next_period="' . (date('F j, Y', strtotime($estimated_next_period))) . '"
                    data-toggle="modal" data-target="#viewFeminineModal">
                        <i class="fa-solid fa-magnifying-glass"></i> View
                </button>
                

                <button type="button" class="btn btn-sm btn-warning text-white delete_record" data-id="' . $feminine['id'] . '"><i class="fa-solid fa-user-xmark"></i> Unassigned</button>
            ';

            $feminine_arr[$feminine_key]['estimated_next_period'] = date('F j, Y', strtotime($estimated_next_period));
            $feminine_arr[$feminine_key]['estimated_menstrual_status'] = $estimated_next_period < date('Y-m-d') ? '<span class="text-danger"><strong>&bull;</strong> Delay</span>' : '<span class="text-success"><strong>&bull;</strong> On Time</span>';
        }

        return response()->json(['data' => $feminine_arr, "recordsFiltered" => count($feminine_arr), 'recordsTotal' => count($feminine_arr)]);
    }

    public function calendarIndex()
    {
        $new_period_notification = $this->newMenstrualPeriodNotificationForHealthWorker();
        return view('health_worker/calendar/index', compact('new_period_notification'));
    }

    public function calendarData()
    {

        // only the active accounts and those who are under the care of this bhw will be processed in the calendar
        $user_list = FeminineHealthWorkerGroup::join('users', 'users.id', '=', 'feminine_health_worker_groups.feminine_id')
            ->where('feminine_health_worker_groups.health_worker_id', Auth::user()->id)
            ->where('users.user_role_id', 2)
            ->where('users.is_active', 1)
            ->get(['users.id', 'users.first_name', 'users.last_name']);

        $last_period_arr = [];
        foreach ($user_list as $user_key => $user) {
            $last_period_arr[$user_key]['name'] = 'Active: ' . $user->last_name . ', ' . $user->first_name;
            $last_period_arr[$user_key]['period_date'] = User::findOrfail($user->id)->last_periods()->first();
        }

        return response()->json($last_period_arr);
    }

    public function healthWorkerFeminineList()
    {
        $assigned_feminine_list = $this->assignedFeminineList(Auth::user()->id);
    
        $feminine_list = User::where('user_role_id', 2)
            ->where('is_active', 1)
            ->whereNotIn('id', $assigned_feminine_list->pluck('id')->toArray())
            ->select(['id', \DB::raw("CONCAT(users.last_name, ', ', users.first_name) AS full_name"), 'address']) // Include the 'address' field in the select
            ->get();
    
        $data = [
            'assigned_feminine_list' => $assigned_feminine_list,
            'feminine_list' => $feminine_list
        ];
    
        return response()->json($data);
    }

    public function postAssignFeminine(Request $request)
    {
        if ($request['feminine_id'] && count($request['feminine_id']) != 0) {
            foreach ($request['feminine_id'] as $user_id) {
                $post_assign_health_worker = FeminineHealthWorkerGroup::firstOrCreate([
                    'feminine_id' => $user_id,
                    'health_worker_id' => $request->id
                ]);
            }
            return response()->json(['status' => 'success', 'message' => count($request['feminine_id']) . ' Feminine successfully assigned.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one feminine.']);
        }
    }

    public function accountSettings()
    {
        if (!Auth::check()) {
            Session::flash('auth-error', 'Please login to continue.');
            return redirect()->route('login.page');
        }

        try {
            $new_period_notification = $this->newMenstrualPeriodNotificationForHealthWorker();
            $user = User::findOrFail(Auth::user()->id);
            return view('health_worker/profile/index', compact('user', 'new_period_notification'));
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

            return response()->json(['success' => true, 'message' => 'Password successfully changed'], 200);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found, please refresh your browser and try again'], 404);
        }
    }

    public function pieChartData()
    {

        $active_feminine_count = User::where('user_role_id', 2)->where('menstruation_status', 1)->count();
        $inactive_feminine_count = User::where('user_role_id', 2)->where('menstruation_status', 0)->count();

        $data_response = [];
        $category_arr = ['Active', 'Inactive'];
        foreach ($category_arr as $category) {
            if ($category === 'Active') {
                if ($active_feminine_count != 0) {
                    $data_response[] = [
                        'value' => $active_feminine_count,
                        'category' => $category,
                    ];
                }
            } else if ($category === 'Inactive') {
                if ($inactive_feminine_count != 0) {
                    $data_response[] = [
                        'value' => $inactive_feminine_count,
                        'category' => $category,
                    ];
                }
            }
        }

        return response()->json($data_response);
    }

    private function assignedFeminineList($health_worker_id)
    {
        return $assigned_feminine_list = FeminineHealthWorkerGroup::where('health_worker_id', $health_worker_id)
            ->with('feminine:id,last_name,first_name')
            ->get(['feminine_id', 'feminine_health_worker_groups.id as feminine_health_worker_group_id'])
            ->map(function ($item) {
                return [
                    'id' => $item->feminine->id,
                    'feminine_health_worker_group_id' => $item->feminine_health_worker_group_id,
                    'full_name' => $item->feminine->full_name(),
                ];
            });
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
