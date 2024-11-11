<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Traits\UserRegistrationTrait;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\MenstruationPeriod;
use App\Models\FeminineHealthWorkerGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

use Barryvdh\DomPDF\Facade\Pdf;

class BarangayHealthWorkerController extends Controller
{
    use UserRegistrationTrait;

    public function index()
    {
        $new_period_notification = $this->newMenstrualPeriodNotificationForHealthWorker();
        $assign_feminine_count = FeminineHealthWorkerGroup::where('health_worker_id', Auth::user()->id)->count();
        $count = $this->healthWorkerFeminineCount();
        $forecastData = $this->generateAdvancedForecastData();

        return view('health_worker.dashboard', compact('assign_feminine_count', 'count', 'new_period_notification', 'forecastData'));
    }

    public function feminineList()
    {
        $new_period_notification = $this->newMenstrualPeriodNotificationForHealthWorker();
        return view('health_worker.feminine.index', compact('new_period_notification'));
    }

    //EDIT
    public function postFeminine(Request $request)
    {
        $feminine = User::findOrFail($request->id);
    
        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => [
                'nullable', // Allow email to be null
                'string',
                'email',
                'max:255',
                Rule::unique('users')
                    ->ignore($feminine->id)
                    ->where(function ($query) {
                        return $query->whereIn('user_role_id', [2, 3]);
                    }),
            ],
            'contact_no' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date_format:m/d/Y', // Validate the date format
            'menstruation_status' => 'nullable|string|max:255',
            'last_period_date' => 'nullable|date_format:m/d/Y', // Add validation for last period date
        ], [
            'email.unique' => 'The email address is already taken.',
            'birthdate.date_format' => 'The birthdate format is invalid. Please use MM/DD/YYYY.',
            'last_period_date.date_format' => 'The last period date format is invalid. Please use MM/DD/YYYY.',
        ]);
    
        // Sanitize input to prevent XSS attacks
        $sanitizedData = [
            'first_name' => strip_tags($request->first_name),
            'middle_name' => $request->filled('middle_name') ? strip_tags($request->middle_name) : null,
            'last_name' => strip_tags($request->last_name),
            'address' => strip_tags($request->address),
            'email' => $request->filled('email') ? strip_tags($request->email) : null,
            'contact_no' => $request->filled('contact_no') ? strip_tags($request->contact_no) : null,
            'menstruation_status' => $request->filled('menstruation_status') ? strip_tags($request->menstruation_status) : null,
        ];
    
        // Check if the email has changed
        if ($feminine->email !== $sanitizedData['email']) {
            $feminine->email = $sanitizedData['email'];
        }
    
        // Update other fields
        $feminine->first_name = $sanitizedData['first_name'];
        $feminine->middle_name = $sanitizedData['middle_name'];
        $feminine->last_name = $sanitizedData['last_name'];
        $feminine->address = $sanitizedData['address'];
        $feminine->contact_no = $sanitizedData['contact_no'];
    
        // Format birthdate if present
        if ($request->filled('birthdate')) {
            $feminine->birthdate = Carbon::createFromFormat('m/d/Y', $request->birthdate)->format('Y-m-d');
        } else {
            $feminine->birthdate = null;
        }
    
        // Update menstruation status
        $feminine->menstruation_status = $sanitizedData['menstruation_status'];
    
        // Save the feminine data
        $feminine->save();
    
        // Handle last_periods data
        $lastPeriod = $feminine->last_periods->first() ?? null;
    
        if ($request->filled('last_period_date')) {
            // Update or create last period information
            if ($lastPeriod) {
                $lastPeriod->menstruation_date = Carbon::createFromFormat('m/d/Y', $request->last_period_date)->format('Y-m-d');
                $lastPeriod->save();
            } else {
                // Create a new record for last period
                $feminine->last_periods()->create([
                    'menstruation_date' => Carbon::createFromFormat('m/d/Y', $request->last_period_date)->format('Y-m-d'),
                ]);
            }
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Female details updated successfully.',
            'data' => [
                'first_name' => htmlspecialchars($feminine->first_name),
                'middle_name' => htmlspecialchars($feminine->middle_name),
                'last_name' => htmlspecialchars($feminine->last_name),
                'email' => htmlspecialchars($feminine->email),
                'address' => htmlspecialchars($feminine->address),
                'contact_no' => htmlspecialchars($feminine->contact_no),
                'birthdate' => $feminine->birthdate ? Carbon::parse($feminine->birthdate)->format('m/d/Y') : null,
                'menstruation_status' => htmlspecialchars($feminine->menstruation_status),
                'remarks' => htmlspecialchars($feminine->remarks ?? null),
                'last_period_date' => $lastPeriod ? Carbon::parse($lastPeriod->menstruation_date
                )->format('m/d/Y') : null,
                'menstruation_period_id' => $lastPeriod ? htmlspecialchars($lastPeriod->id) : null,
            ]
        ]);
    }
    
    public function postnewfeminine(Request $request)
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
        try {
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
                } else {
                    $estimated_next_period = 'N/A';
                }
    
                $feminine_arr[$feminine_key]['row_count'] = ++$row_count;
                $feminine_arr[$feminine_key]['full_name'] = $full_name;
                $feminine_arr[$feminine_key]['menstruation_status'] = '<span class="text-' . ($feminine['menstruation_status'] === 1 ? 'success' : 'danger') . '"><strong>&bull;</strong> ' . ($feminine['menstruation_status'] === 1 ? 'Regular' : 'Irregular') . '</span>';
    
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
                        data-estimated_next_period="' . (is_string($estimated_next_period) ? $estimated_next_period : date('F j, Y', strtotime($estimated_next_period))) . '"
                        data-toggle="modal" data-target="#viewFeminineModal">
                            <i class="fa-solid fa-magnifying-glass"></i> View
                    </button>
    
                    <button type="button" class="btn btn-sm btn-primary"
                        data-id="' . $feminine['id'] . '"
                        data-first_name="' . $feminine['first_name'] . '"
                        data-last_name="' . $feminine['last_name'] . '"
                        data-middle_name="' . $feminine['middle_name'] . '"
                        data-email="' . $feminine['email'] . '"
                        data-contact_no="' . $feminine['contact_no'] . '"
                        data-address="' . $feminine['address'] . '"
                        data-birthdate="' . ($feminine['birthdate'] ? date('m/d/Y', strtotime($feminine['birthdate'])) : null) . '"
                        data-menstruation_status="' . $feminine['menstruation_status'] . '"
                        data-remarks="' . ($feminine['remarks'] ?? null) . '"
                        data-last_period_date="' . (count($last_period_list) != 0 ? date('m/d/Y', strtotime($last_period_list->first()->menstruation_date)) : null) . '"
                        data-menstruation_period_id="' . (count($last_period_list) != 0 ? $last_period_list->first()->id : null) . '"
                        data-toggle="modal" data-target="#editFeminineModal">
                            <i class="fa-solid fa-user-pen"></i> Edit
                    </button>
                    
                    <button type="button" class="btn btn-sm btn-warning text-white delete_record" data-id="' . $feminine['id'] . '"><i class="fa-solid fa-user-xmark"></i> Unassigned</button>
                ';
    
                $feminine_arr[$feminine_key]['estimated_next_period'] = is_string($estimated_next_period) ? $estimated_next_period : date('F j, Y', strtotime($estimated_next_period));
                $feminine_arr[$feminine_key]['estimated_menstrual_status'] = !is_string($estimated_next_period) && $estimated_next_period < date('Y-m-d') ? '<span class="text-danger"><strong>&bull;</strong> Delay</span>' : '<span class="text-success"><strong>&bull;</strong> On Time</span>';
            }
    
            return response()->json(['data' => $feminine_arr, "recordsFiltered" => count($feminine_arr), 'recordsTotal' => count($feminine_arr)]);
        } catch (\Exception $e) {
            \Log::error('Error fetching feminine data: ', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

    public function healthWorkerFeminineList(Request $request)
    {
        $healthWorker = User::find($request->health_worker_id);
        \Log::info('Health Worker Address: ' . $healthWorker->address);
    
        $assigned_feminine_list = $this->assignedFeminineList($healthWorker->id);
    
        $feminine_list = User::where('user_role_id', 2)
            ->where('is_active', 1)
            ->whereNotIn('id', $assigned_feminine_list->pluck('id')->toArray())
            ->where('address', $healthWorker->address) // Filter based on health worker's address
            ->select([
                'id',
                \DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS full_name"), // Alias it as `full_name`
                'address'
            ])
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
            // Find the user
            $user = User::findOrFail($request->id);
    
            // Validate the request
            $check_validation = Validator::make($request->all(), [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => [
                    'nullable',
                    'email',
                    'max:100',
                    Rule::unique('users', 'email')->ignore($user->id)
                ],
                'birthdate' => 'required|date|before:today',
                'contact_no' => [
                    'numeric',
                    'nullable',
                    'regex:/^\d{10,11}$/',
                    Rule::unique('users', 'contact_no')->ignore($user->id),
                    'required_if:email,null'
                ],
            ], [
                'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
                'contact_no.unique' => 'The contact number has already been taken.',
                'unique' => 'The :attribute field has already been taken.'
            ]);
    
            // Check for validation errors
            if ($check_validation->fails()) {
                return response()->json(['success' => false, 'message' => $check_validation->errors()->first()], 500);
            }
    
            // Ensure the authenticated user is updating their own profile
            if (!isset($request->id) || Auth::user()->id != $request->id) {
                return response()->json(['success' => false, 'message' => 'Something went wrong, failed to save data. Please try again.'], 500);
            }
    
            // Sanitize input to prevent XSS attacks
            $sanitizedData = [
                'first_name' => htmlspecialchars($request->first_name),
                'middle_name' => isset($request->middle_name) ? htmlspecialchars($request->middle_name) : null,
                'last_name' => htmlspecialchars($request->last_name),
                'email' => isset($request->email) ? htmlspecialchars($request->email) : null,
                'contact_no' => isset($request->contact_no) ? htmlspecialchars($request->contact_no) : null,
                'address' => isset($request->address) ? htmlspecialchars($request->address) : null,
                'birthdate' => date('Y-m-d', strtotime($request->birthdate)),
                'remarks' => isset($request->remarks) ? htmlspecialchars($request->remarks) : null,
            ];
    
            // Update user data
            $user->fill($sanitizedData);
            $user->save();
    
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
        $health_worker_id = Auth::user()->id;

        // Count active and inactive feminines assigned to the logged-in health worker
        $active_feminine_count = FeminineHealthWorkerGroup::where('health_worker_id', $health_worker_id)
            ->whereHas('feminine', function ($query) {
                $query->where('user_role_id', 2)->where('menstruation_status', 1);
            })
            ->count();

        $inactive_feminine_count = FeminineHealthWorkerGroup::where('health_worker_id', $health_worker_id)
            ->whereHas('feminine', function ($query) {
                $query->where('user_role_id', 2)->where('menstruation_status', 0);
            })
            ->count();

        $data_response = [];
        $category_arr = ['Regular', 'Irregular'];

        foreach ($category_arr as $category) {
            if ($category === 'Regular' && $active_feminine_count != 0) {
                $data_response[] = [
                    'value' => $active_feminine_count,
                    'category' => $category,
                ];
            } elseif ($category === 'Irregular' && $inactive_feminine_count != 0) {
                $data_response[] = [
                    'value' => $inactive_feminine_count,
                    'category' => $category,
                ];
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

    public function print_pdf($id)
    {
        $pdf = Pdf::loadView('health_worker.invoice');
        return $pdf->download('invoice.pdf');
    }
    
    //chart forecast//
    private function generateAdvancedForecastData()
    {
        $healthWorkerId = Auth::user()->id;
        $now = Carbon::now();
        $forecastMonths = 12;

        $feminines = FeminineHealthWorkerGroup::where('health_worker_id', $healthWorkerId)
            ->with(['feminine', 'feminine.menstruationPeriods' => function ($query) {
                $query->orderBy('menstruation_date', 'desc')->take(6);
            }])
            ->get()
            ->pluck('feminine');

        $labels = [];
        $datasets = [
            'regular' => [],
            'irregular' => [],
            'at_risk' => [],
            'pregnant' => [],
        ];

        $monthlyData = [];

        for ($i = 0; $i < $forecastMonths; $i++) {
            $month = $now->copy()->addMonths($i);
            $labels[] = $month->format('M Y');

            $statuses = [
                'regular' => 0,
                'irregular' => 0,
                'at_risk' => 0,
                'pregnant' => 0,
            ];

            foreach ($feminines as $feminine) {
                $status = $this->predictMenstrualStatus($feminine, $month);
                $statuses[$status]++;
            }

            foreach ($datasets as $key => $value) {
                $datasets[$key][] = $statuses[$key];
            }

            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'statuses' => $statuses,
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
            'monthlyData' => $monthlyData,
        ];
    }

    private function predictMenstrualStatus($feminine, $targetMonth)
    {
        $periods = $feminine->menstruationPeriods;
        if ($periods->isEmpty()) {
            return 'irregular';
        }

        $lastPeriod = $periods->first();
        $age = Carbon::parse($feminine->birthdate)->age;

        // Calculate average cycle length and variability
        $cycleLengths = [];
        for ($i = 0; $i < $periods->count() - 1; $i++) {
            $cycleLengths[] = $this->ensureCarbonDate($periods[$i]->menstruation_date)
                ->diffInDays($this->ensureCarbonDate($periods[$i + 1]->menstruation_date));
        }
        $avgCycleLength = count($cycleLengths) > 0 ? array_sum($cycleLengths) / count($cycleLengths) : 28;
        $cycleVariability = count($cycleLengths) > 1 ? $this->standardDeviation($cycleLengths) : 0;

        // Ensure $lastPeriod->menstruation_date and $targetMonth are Carbon instances
        $lastPeriodDate = $this->ensureCarbonDate($lastPeriod->menstruation_date);
        $targetMonth = $this->ensureCarbonDate($targetMonth);

        // Predict next period
        $predictedNextPeriod = $lastPeriodDate->copy()->addDays(round($avgCycleLength));
        $daysSinceLastPeriod = $targetMonth->diffInDays($lastPeriodDate);

        // Determine status
        if ($daysSinceLastPeriod > 60) {
            return 'pregnant';
        } elseif ($cycleVariability > 7 || abs($daysSinceLastPeriod - $avgCycleLength) > 7) {
            return 'irregular';
        } elseif ($age > 45 || ($age > 40 && $cycleVariability > 5)) {
            return 'at_risk';
        } else {
            return 'regular';
        }
    }

    private function ensureCarbonDate($date)
    {
        if (!$date instanceof Carbon) {
            return Carbon::parse($date);
        }
        return $date;
    }
    
    private function standardDeviation(array $numbers)
    {
        $mean = array_sum($numbers) / count($numbers);
        $variance = array_sum(array_map(function($x) use ($mean) {
            return pow($x - $mean, 2);
        }, $numbers)) / count($numbers);
        return sqrt($variance);
    }  

    public function menstruationPeriods()
    {
        return $this->hasMany(MenstruationPeriod::class)->orderBy('menstruation_date', 'desc');
    }    
}


