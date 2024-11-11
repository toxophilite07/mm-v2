<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\UserRegistrationTrait;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\User;
use App\Models\MenstruationPeriod;
use App\Models\FeminineHealthWorkerGroup;
use App\Mail\HealthWorkerVerifiedMail;
use App\Mail\FeminineVerifiedMail;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller {

    use UserRegistrationTrait;

    public function index() {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You don\'t have authorization to access admin portal, please try again.');
        }
    
        // Fetch notifications and counts
        $new_notification = $this->signupNotification();
        $new_health_worker_notification = $this->healthWorkerSignupNotification(); 
        $new_period_notification = $this->newMenstrualPeriodNotification();
        $count = $this->feminineCount();
    
        // Count total menstrual periods per year
        $total_period_per_year = MenstruationPeriod::whereYear('menstruation_date', date('Y'))->count();
    
        // Count of health workers
        $health_worker_count = User::where('user_role_id', 3)->where('is_active', 1)->count();
        $hw_count = User::where('user_role_id', 3)->count();
        $verified_users_count = User::whereIn('user_role_id', [2, 3])->where('is_active', 1)->count();
    
        // Count of users excluding admin
        $users_count = User::whereIn('user_role_id', [2, 3])->count();
        $verified_feminine_count = User::where('user_role_id', 2)->count();
    
        // Count of inactive users
        $inactive_count = User::whereIn('user_role_id', [2, 3])->where('is_active', 0)->count();
        $inactive_hw_count = User::where('user_role_id', 3)->where('is_active', 0)->count();
        $inactive_user_count = User::where('user_role_id', 2)->where('is_active', 0)->count();
        $active_user_count = User::where('user_role_id', 2)->where('is_active', 1)->count();
    
        // Count of barangays
        $unique_barangay_count = User::where('user_role_id', 2, 3) // Assuming '2' is the role ID for feminines
        ->distinct('address') // Get distinct addresses
        ->count('address'); // Ensure you have a Barangay model
    
        // Pass data to the view
        return view('admin.dashboard', compact(
            'count', 
            'new_notification', 
            'new_health_worker_notification',
            'new_period_notification', 
            'total_period_per_year', 
            'health_worker_count', 
            'users_count', 
            'inactive_count',
            'inactive_hw_count',
            'inactive_user_count',
            'active_user_count',
            'hw_count',
            'verified_feminine_count',
            'verified_users_count',
            'unique_barangay_count' // Include the barangay count
        ));
    }
    
    public function pieChartData() {
        
        $active_feminine_count = User::where('user_role_id', 2)->where('menstruation_status', 1)->count();
        $inactive_feminine_count = User::where('user_role_id', 2)->where('menstruation_status', 0)->count();
        $pending_feminine_count = User::where('user_role_id', 2)->where('is_active', 0)->count();

        $data_response = [];
        $category_arr = ['Active Period', 'Inactive Period', 'Pending Feminine'];
        foreach($category_arr as $category) {
            if($category === 'Active Period') {
                if($active_feminine_count != 0) {
                    $data_response[] = [
                        'value' => $active_feminine_count,
                        'category' => $category,
                    ];
                }
            }
            else if($category === 'Inactive Period') {
                if($inactive_feminine_count != 0) {
                    $data_response[] = [
                        'value' => $inactive_feminine_count,
                        'category' => $category,
                    ];
                }
            }
            else if($category === 'Pending Feminine') {
                if($pending_feminine_count != 0) {
                    $data_response[] = [
                        'value' => $pending_feminine_count,
                        'category' => $category,
                    ];
                }
            }
        }

        return response()->json($data_response);
    }

    public function graphData() {
        $year = date('Y');
        $month_arr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $data_response = [];
        foreach($month_arr as $month) {
            $data_response[] = [
                'month' => $month,
                'count' => MenstruationPeriod::whereMonth('menstruation_date', date('m', strtotime($month)))
                    ->whereYear('menstruation_date', $year)
                    ->count()
            ];
        }

        return response()->json($data_response);
    }

    public function menstrualCyclePrediction()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $periods = MenstruationPeriod::where('user_id', $user->id)
            ->orderBy('menstruation_date', 'desc')
            ->take(5)
            ->get();
    
        $cycle_lengths = [];
        for ($i = 0; $i < count($periods) - 1; $i++) {
            $cycle_lengths[] = Carbon::parse($periods[$i]->menstruation_date)
                ->diffInDays(Carbon::parse($periods[$i + 1]->menstruation_date));
        }
    
        $average_cycle_length = count($cycle_lengths) > 0 ? array_sum($cycle_lengths) / count($cycle_lengths) : 28;
    
        $predictions = [];
        $last_period_date = $periods->first() ? Carbon::parse($periods->first()->menstruation_date) : Carbon::now();
        
        for ($i = 0; $i < 12; $i++) {
            $next_period_date = $last_period_date->copy()->addDays($average_cycle_length);
            $predictions[] = [
                'month' => $next_period_date->format('F'),
                'year' => $next_period_date->year,
                'predicted_date' => $next_period_date->format('Y-m-d'),
                'status' => $this->determineStatus($next_period_date, $last_period_date, $average_cycle_length),
            ];
            $last_period_date = $next_period_date;
        }
    
        return response()->json($predictions);
    }
    
    private function determineStatus($predicted_date, $last_period_date, $average_cycle_length)
    {
        $current_date = Carbon::now();
        $days_since_last_period = $current_date->diffInDays($last_period_date);
        $days_until_prediction = $current_date->diffInDays($predicted_date, false);
    
        if ($days_until_prediction <= 0 && $days_until_prediction > -5) {
            return 'On Period';
        }
    
        if ($days_since_last_period > 60) {  // Example threshold for irregularity
            return 'Irregular';
        }
    
        if ($days_since_last_period > $average_cycle_length + 14) {  // Potential pregnancy
            return 'Pregnant';
        }
    
        return 'Normal';
    }

    public function feminineList() {
        $new_notification = $this->signupNotification() ?? [];
        $new_period_notification = $this->newMenstrualPeriodNotification() ?? [];
        $new_health_worker_notification = $this->healthWorkerSignupNotification() ?? [];
        
        $new_notification = $new_notification->sortByDesc('created_at');
        $new_health_worker_notification = $new_health_worker_notification->sortByDesc('created_at');
    
        \Log::info('New Notifications: ', $new_notification->toArray());
        \Log::info('New Health Worker Notifications: ', $new_health_worker_notification->toArray());
        
        return view('admin/feminine/index', compact('new_notification', 'new_period_notification', 'new_health_worker_notification'));
    }
    private function healthWorkerSignupNotification() {
        return User::where('user_role_id', 3) // Assuming 3 is the role ID for health workers
                   ->where('is_active', 0)
                   ->orderBy('created_at', 'DESC')
                   ->get();
    }    

    //OLD W/SANITIZED//
    // public function postFeminine(Request $request)
    // {
    //     $feminine = User::findOrFail($request->id);
    
    //     // Validate the request
    //     $validatedData = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'middle_name' => 'nullable|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'email' => [
    //             'nullable', // Allow email to be null
    //             'string',
    //             'email',
    //             'max:255',
    //             Rule::unique('users')
    //                 ->ignore($feminine->id)
    //                 ->where(function ($query) {
    //                     return $query->whereIn('user_role_id', [2, 3]);
    //                 }),
    //         ],
    //         'contact_no' => 'nullable|string|max:255',
    //         'birthdate' => 'nullable|date_format:m/d/Y', // Validate the date format
    //         'menstruation_status' => 'nullable|string|max:255',
    //         'last_period_date' => 'nullable|date_format:m/d/Y', // Add validation for last period date
    //     ], [
    //         'email.unique' => 'The email address is already taken.',
    //         'birthdate.date_format' => 'The birthdate format is invalid. Please use MM/DD/YYYY.',
    //         'last_period_date.date_format' => 'The last period date format is invalid. Please use MM/DD/YYYY.',
    //     ]);
    
    //     // Sanitize input to prevent XSS attacks
    //     $sanitizedData = [
    //         'first_name' => strip_tags($request->first_name),
    //         'middle_name' => $request->filled('middle_name') ? strip_tags($request->middle_name) : null,
    //         'last_name' => strip_tags($request->last_name),
    //         'address' => strip_tags($request->address),
    //         'email' => $request->filled('email') ? strip_tags($request->email) : null,
    //         'contact_no' => $request->filled('contact_no') ? strip_tags($request->contact_no) : null,
    //         'menstruation_status' => $request->filled('menstruation_status') ? strip_tags($request->menstruation_status) : null,
    //     ];
    
    //     // Check if the email has changed
    //     if ($feminine->email !== $sanitizedData['email']) {
    //         $feminine->email = $sanitizedData['email'];
    //     }
    
    //     // Update other fields
    //     $feminine->first_name = $sanitizedData['first_name'];
    //     $feminine->middle_name = $sanitizedData['middle_name'];
    //     $feminine->last_name = $sanitizedData['last_name'];
    //     $feminine->address = $sanitizedData['address'];
    //     $feminine->contact_no = $sanitizedData['contact_no'];
    
    //     // Format birthdate if present
    //     if ($request->filled('birthdate')) {
    //         $feminine->birthdate = Carbon::createFromFormat('m/d/Y', $request->birthdate)->format('Y-m-d');
    //     } else {
    //         $feminine->birthdate = null;
    //     }
    
    //     // Update menstruation status
    //     $feminine->menstruation_status = $sanitizedData['menstruation_status'];
    
    //     // Save the feminine data
    //     $feminine->save();
    
    //     // Handle last_periods data
    //     $lastPeriod = $feminine->last_periods->first() ?? null;
    
    //     if ($request->filled('last_period_date')) {
    //         // Update or create last period information
    //         if ($lastPeriod) {
    //             $lastPeriod->menstruation_date = Carbon::createFromFormat('m/d/Y', $request->last_period_date)->format('Y-m-d');
    //             $lastPeriod->save();
    //         } else {
    //             // Create a new record for last period
    //             $feminine->last_periods()->create([
    //                 'menstruation_date' => Carbon::createFromFormat('m/d/Y', $request->last_period_date)->format('Y-m-d'),
    //             ]);
    //         }
    //     }
    
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Feminine details updated successfully.',
    //         'data' => [
    //             'first_name' => htmlspecialchars($feminine->first_name),
    //             'middle_name' => htmlspecialchars($feminine->middle_name),
    //             'last_name' => htmlspecialchars($feminine->last_name),
    //             'email' => htmlspecialchars($feminine->email),
    //             'address' => htmlspecialchars($feminine->address),
    //             'contact_no' => htmlspecialchars($feminine->contact_no),
    //             'birthdate' => $feminine->birthdate ? Carbon::parse($feminine->birthdate)->format('m/d/Y') : null,
    //             'menstruation_status' => htmlspecialchars($feminine->menstruation_status),
    //             'remarks' => htmlspecialchars($feminine->remarks ?? null),
    //             'last_period_date' => $lastPeriod ? Carbon::parse($lastPeriod->menstruation_date)->format('m/d/Y') : null,
    //             'menstruation_period_id' => $lastPeriod ? htmlspecialchars($lastPeriod->id) : null,
    //         ]
    //     ]);
    // }

    //NEW EDIT WITH SANITIZE//
    //     public function postFeminine(Request $request)
    // {
    //     $feminine = User::findOrFail($request->id);

    //     // Validate the request
    //     $validatedData = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'middle_name' => 'nullable|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'email' => [
    //             'nullable', // Allow email to be null
    //             'string',
    //             'email',
    //             'max:255',
    //             Rule::unique('users')
    //                 ->ignore($feminine->id)
    //                 ->where(function ($query) {
    //                     return $query->whereIn('user_role_id', [2, 3]);
    //                 }),
    //         ],
    //         'contact_no' => 'nullable|string|max:255',
    //         'birthdate' => 'nullable|date_format:m/d/Y', // Validate the date format
    //         'menstruation_status' => 'nullable|string|max:255',
    //         'last_period_date' => 'nullable|date_format:m/d/Y', // Add validation for last period date
    //     ], [
    //         'email.unique' => 'The email address is already taken.',
    //         'birthdate.date_format' => 'The birthdate format is invalid. Please use MM/DD/YYYY.',
    //         'last_period_date.date_format' => 'The last period date format is invalid. Please use MM/DD/YYYY.',
    //     ]);

    //     // Sanitize input to prevent XSS attacks
    //     $sanitizedData = [
    //         'first_name' => strip_tags($request->first_name),
    //         'middle_name' => $request->filled('middle_name') ? strip_tags($request->middle_name) : null,
    //         'last_name' => strip_tags($request->last_name),
    //         'address' => strip_tags($request->address),
    //         'email' => $request->filled('email') ? strip_tags($request->email) : null,
    //         'contact_no' => $request->filled('contact_no') ? strip_tags($request->contact_no) : null,
    //         'menstruation_status' => $request->filled('menstruation_status') ? strip_tags($request->menstruation_status) : null,
    //     ];

    //     // Check if the email has changed
    //     if ($feminine->email !== $sanitizedData['email']) {
    //         $feminine->email = $sanitizedData['email'];
    //     }

    //     // Update other fields
    //     $feminine->first_name = $sanitizedData['first_name'];
    //     $feminine->middle_name = $sanitizedData['middle_name'];
    //     $feminine->last_name = $sanitizedData['last_name'];
    //     $feminine->address = $sanitizedData['address'];
    //     $feminine->contact_no = $sanitizedData['contact_no'];

    //     // Format birthdate if present
    //     if ($request->filled('birthdate')) {
    //         $feminine->birthdate = Carbon::createFromFormat('m/d/Y', $request->birthdate)->format('Y-m-d');
    //     } else {
    //         $feminine->birthdate = null;
    //     }

    //     // Update menstruation status
    //     $feminine->menstruation_status = $sanitizedData['menstruation_status'];

    //     // Save the feminine data
    //     $feminine->save();

    //     // Handle last_periods data
    //     $lastPeriod = $feminine->last_periods->first() ?? null;

    //     if ($request->filled('last_period_date')) {
    //         // Update or create last period information
    //         if ($lastPeriod) {
    //             $lastPeriod->menstruation_date = Carbon::createFromFormat('m/d/Y', $request->last_period_date)->format('Y-m-d');
    //             $lastPeriod->save();
    //         } else {
    //             // Create a new record for last period
    //             $feminine->last_periods()->create([
    //                 'menstruation_date' => Carbon::createFromFormat('m/d/Y', $request->last_period_date)->format('Y-m-d'),
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Feminine details updated successfully.',
    //         'data' => [
    //             'first_name' => htmlspecialchars($feminine->first_name),
    //             'middle_name' => htmlspecialchars($feminine->middle_name),
    //             'last_name' => htmlspecialchars($feminine->last_name),
    //             'email' => htmlspecialchars($feminine->email),
    //             'address' => htmlspecialchars($feminine->address),
    //             'contact_no' => htmlspecialchars($feminine->contact_no),
    //             'birthdate' => $feminine->birthdate ? Carbon::parse($feminine->birthdate)->format('m/d/Y') : null,
    //             'menstruation_status' => htmlspecialchars($feminine->menstruation_status),
    //             'remarks' => htmlspecialchars($feminine->remarks ?? null),
    //             'last_period_date' => $lastPeriod ? Carbon::parse($lastPeriod->menstruation_date)->format('m/d/Y') : null,
    //             'menstruation_period_id' => $lastPeriod ? htmlspecialchars($lastPeriod->id) : null,
    //         ]
    //     ]);
    // }

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
            'email' => $request->filled('email') ? strip_tags($request->email) : null, // Allow email to be null
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
            'message' => 'Feminine details updated successfully.',
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
                'last_period_date' => $lastPeriod ? Carbon::parse($lastPeriod->menstruation_date)->format('m/d/Y') : null,
                'menstruation_period_id' => $lastPeriod ? htmlspecialchars($lastPeriod->id) : null,
            ]
        ]);
    }

    //NEW POST WITH SANITIZED
    public function postnewfeminine(Request $request)
    {
            // Validate the input
            $validatedData = $request->validate([
                'first_name'          => 'required|string|max:255',
                'middle_name'         => 'nullable|string|max:255',
                'last_name'           => 'required|string|max:255',
                'address'             => 'required|string|max:255',
                'birthdate'           => 'required|date|before:today',
                'email'               => 'nullable|email|max:255',
                'contact_no'          => 'nullable|regex:/^9[0-9]{9}$/', // Validate contact number (10 digits starting with 9)
                'menstruation_status' => 'required|boolean', // 1 for regular, 0 for irregular
                'last_period_date'    => 'nullable|date',
                'remarks'             => 'nullable|string|max:1000',
            ]);
        
            // Sanitize inputs (remove potentially harmful HTML tags)
            $sanitizedData = [
                'first_name'          => strip_tags($validatedData['first_name']),
                'middle_name'         => strip_tags($validatedData['middle_name']),
                'last_name'           => strip_tags($validatedData['last_name']),
                'address'             => strip_tags($validatedData['address']),
                'birthdate'           => $validatedData['birthdate'], // Assuming no tags
                'email'               => strip_tags($validatedData['email']),
                'contact_no'          => $validatedData['contact_no'], // Assuming no tags
                'menstruation_status' => $validatedData['menstruation_status'],
                'last_period_date'    => $validatedData['last_period_date'], // Assuming no tags
                'remarks'             => strip_tags($validatedData['remarks']),
            ];
        
            // Process the form submission with sanitized data
            return $this->postForm($sanitizedData);
    }

   //OLD w/ SATNITIZED// 
    // public function postnewfeminine(Request $request)
    // {
    //     return $this->postForm($request->all());
    // }
    
    public function deleteFeminie(Request $request) {
        try {
            $user = User::findOrFail($request->id);

            if($user) {
                $user->last_periods()->delete();
                $user->delete();
            }

            return response()->json(['status' => 'success', 'message' => 'Feminine successfully deleted.']);
        }
        catch(\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function confirmFeminine(Request $request)
    {
        try {
            $post_confirm = User::findOrFail($request->id);  // Find feminine user by ID
            $post_confirm->is_active = 1;  // Mark as confirmed
            $post_confirm->save();  // Save the changes
    
            // Send verification email to the feminine user
            Mail::to($post_confirm->email)->send(new FeminineVerifiedMail($post_confirm));
    
            return response()->json([
                'status' => 'success',
                'message' => 'Female successfully confirmed.',
                'new_notification_count' => count($this->signupNotification())
            ]);
        } catch (\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please refresh your browser and try again.'
            ]);
        }
    }
    

    // FOR HEALTH WORKER
    public function confirmHealthWorker(Request $request) {
        try {
            $health_worker = User::findOrFail($request->id);
            $health_worker->is_active = 1;
            $health_worker->save();
    
            // Send email to the health worker notifying them of the verification
            Mail::to($health_worker->email)->send(new HealthWorkerVerifiedMail($health_worker));
    
            return response()->json(['status' => 'success', 'message' => 'Health worker successfully confirmed.', 'new_notification_count' => count($this->signupNotification())]);
        } catch(\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please refresh your browser and try again.']);
        }
    }
    
    
    public function calendarIndex() {
        $new_notification = $this->signupNotification();
        $new_period_notification = $this->newMenstrualPeriodNotification();
        $new_health_worker_notification = $this->healthWorkerSignupNotification();
        return view('admin/calendar/index', compact('new_notification', 'new_period_notification', 'new_health_worker_notification'));
    }

    public function calendarData() {

        // only the active accounts will be processed in the calendar
        $user_list = User::where('user_role_id', 2)
            ->where('is_active', 1)
            ->get(['id', 'first_name', 'last_name']);

        $last_period_arr = [];
        foreach($user_list as $user_key => $user) {
            $last_period_arr[$user_key]['name'] = $user->last_name.', '.$user->first_name;
            $last_period_arr[$user_key]['period_date'] = $user->last_periods()->first();
        }

        return response()->json($last_period_arr);
    }

    public function feminineData() {

        $feminine_arr = User::with('last_periods')
            ->where('user_role_id', 2)
            ->orderBy('last_name', 'ASC')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'address', 'email', 'contact_no', 'birthdate', 'menstruation_status', 'is_active', 'remarks'])
            ->toArray();

        $row_count = 0;
        foreach($feminine_arr as $feminine_key => $feminine) {

            $assign_status = FeminineHealthWorkerGroup::where('feminine_id', $feminine['id']);

            if($assign_status->count() != 0) {
                $assign_health_worker_list = $assign_status->join('users', 'users.id', '=', 'feminine_health_worker_groups.health_worker_id')
                    ->where('users.user_role_id', 3)
                    ->get(['users.first_name', 'users.last_name']);

                $assign_health_worker_arr = '';
                foreach($assign_health_worker_list as $assign_health_worker) {
                    $assign_health_worker_arr .= '• '.$assign_health_worker->last_name.', '.$assign_health_worker->first_name.'<br>';
                }
            }


            $full_name = $feminine['last_name'].', '.$feminine['first_name'].' '.$feminine['middle_name'];
        
            $feminine_arr[$feminine_key]['row_count'] = ++$row_count;
            $feminine_arr[$feminine_key]['full_name'] = $full_name;
            $feminine_arr[$feminine_key]['menstruation_status'] = '<span class="text-' . ($feminine['menstruation_status'] === 1 ? 'success' : 'danger') . '"><strong>&bull;</strong> ' . ($feminine['menstruation_status'] === 1 ? 'Regular' : 'Irregular') . '</span>';

            $feminine_arr[$feminine_key]['is_assigned'] = '
                <span class="text-' . ($assign_status->count() === 0 ? 'warning' : 'success') . '"><strong>&bull;</strong> ' . ($assign_status->count() === 0 ? 'Not Assigned' : 'Assigned') . '</span>
            ';

            if($feminine['is_active'] === 1) {
                $feminine_arr[$feminine_key]['is_active'] = '<span class="text-success"><strong>&bull;</strong> Verified</span>';
            }
            else {
                $feminine_arr[$feminine_key]['is_active'] = '<button type="button" class="btn btn-sm btn-success verify_account" id="notif_'. $feminine['id'] .'" data-id="'. $feminine['id'] .'" data-full_name="'. $full_name .'" ><i class="fa-solid fa-user-check"></i> Verify</button>';
            }

            $feminine_arr[$feminine_key]['action'] = '
                <button type="button" class="btn btn-sm btn-secondary" id="period_notif_'. $feminine['id'] .'"
                    data-full_name="'.$full_name.'"
                    data-email="'.($feminine['email'] ?? 'N/A').'"
                    data-address="'.$feminine['address'].'"
                    data-birthdate="'. ($feminine['birthdate'] ? date('F j, Y', strtotime($feminine['birthdate'])) : 'N/A') .'"
                    data-menstruation_status="'.$feminine['menstruation_status'].'"
                    data-is_active="'.$feminine['is_active'].'"
                    data-remarks="'.($feminine['remarks'] ?? 'N/A').'"
                    data-contact_no="'.($feminine['contact_no'] ?? '').'"
                    data-last_period_dates='.(json_encode(array_slice($feminine['last_periods'], 0, 3)) ?? 'N/A').'
                    data-assign_bhw="'. ($assign_status->count() != 0 ? $assign_health_worker_arr : null) .'"
                    data-toggle="modal" data-target="#viewFeminineModal">
                        <i class="fa-solid fa-magnifying-glass"></i> View
                </button>
                
                <button type="button" class="btn btn-sm btn-primary"
                    data-id="'.$feminine['id'].'"
                    data-first_name="'.$feminine['first_name'].'"
                    data-last_name="'.$feminine['last_name'].'"
                    data-middle_name="'.$feminine['middle_name'].'"
                    data-email="'.$feminine['email'].'"
                    data-address="'.$feminine['address'].'"
                    data-contact_no="'.$feminine['contact_no'].'"
                    data-birthdate="'. ($feminine['birthdate'] ? date('m/d/Y', strtotime($feminine['birthdate'])) : null) .'"
                    data-menstruation_status="'.$feminine['menstruation_status'].'"
                    data-remarks="'.($feminine['remarks'] ?? null).'"
                    data-last_period_date="' . (empty($feminine['last_periods']) ? null : date('m/d/Y', strtotime($feminine['last_periods'][0]['menstruation_date']))) . '"
                    data-menstruation_period_id="'. (empty($feminine['last_periods']) ? null : $feminine['last_periods'][0]['id']) .'"
                    data-toggle="modal" data-target="#editFeminineModal">
                        <i class="fa-solid fa-user-pen"></i> Edit
                </button>

                <button type="button" class="btn btn-sm btn-danger delete_record" data-id="'.$feminine['id'].'"><i class="fa-solid fa-trash"></i> Delete</button>
            ';
        }

        return response()->json(['data'=>$feminine_arr, "recordsFiltered"=>count($feminine_arr), 'recordsTotal'=>count($feminine_arr)]);
    }

    public function accountSettings() {
        $new_notification = $this->signupNotification();
        $new_period_notification = $this->newMenstrualPeriodNotification();
        $new_health_worker_notification = $this->healthWorkerSignupNotification();
        return view('admin/account_settings/index', compact('new_notification', 'new_period_notification', 'new_health_worker_notification'));

    }

    public function accountReset(Request $request) {
        try {
            $user = User::findOrFail($request->id);
            $user->password = Hash::make('password'); // reset the password to "password"
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Password successfully reset.']);
        }
        catch(\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found, please try again.']);
        }
        catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function accountData() {
        
        $feminine_arr = User::whereIn('user_role_id', [2, 3])
            ->where('is_active', 1)
            ->orderBy('last_name', 'ASC')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'email', 'user_role_id'])
            ->toArray();

        $row_count = 0;
        foreach($feminine_arr as $feminine_key => $feminine) {

            $full_name = $feminine['last_name'].', '.$feminine['first_name'].' '.$feminine['middle_name'];

            $feminine_arr[$feminine_key]['row_count'] = ++$row_count;
            $feminine_arr[$feminine_key]['full_name'] = $full_name;
            $feminine_arr[$feminine_key]['user_role_id'] = '<span class="text-' . ($feminine['user_role_id'] == 2 ? 'success' : 'primary') . '"><strong>&bull;</strong> ' . ($feminine['user_role_id'] == 2 ? 'Feminine' : 'Health Worker') . '</span>';
            $feminine_arr[$feminine_key]['action'] = '<button type="button" class="btn btn-sm btn-primary reset_password" data-id="'.$feminine['id'].'" data-full_name="'.$full_name.'"><i class="fa-solid fa-key"></i> Reset Password</button>';
        }

        return response()->json(['data'=>$feminine_arr, "recordsFiltered"=>count($feminine_arr), 'recordsTotal'=>count($feminine_arr)]);
    }

    public function postSeenPeriodNotification(Request $request) {
        if($request->id) {
            try {
                $post_notification_seen = MenstruationPeriod::findOrFail($request->id);
                $post_notification_seen->is_seen = 1;
                $post_notification_seen->save();

                return response()->json(['status' => 'success', 'id' => $post_notification_seen->id, 'new_notification_count' => count($this->newMenstrualPeriodNotification())]);
            }
            catch(\ModelNotFoundException $e) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
            }
        }
    }

    public function healthWorkerIndex() {
        $new_notification = $this->signupNotification() ?? [];
        $new_period_notification = $this->newMenstrualPeriodNotification() ?? [];
        $new_health_worker_notification = $this->healthWorkerSignupNotification() ?? [];
        
        $new_notification = $new_notification->sortByDesc('created_at');
        $new_health_worker_notification = $new_health_worker_notification->sortByDesc('created_at');
    
        \Log::info('New Notifications: ', $new_notification->toArray());
        \Log::info('New Health Worker Notifications: ', $new_health_worker_notification->toArray());
        
        return view('admin/health_worker/index', compact('new_notification', 'new_period_notification', 'new_health_worker_notification'));
    }
    ///WITHOUT SANITIZED
    // public function postHealthWorker(Request $request)
        // {
        //     $health_worker = User::findOrFail($request->id);
        
        //     // Validate the request
        //     $validatedData = $request->validate([
        //         'first_name' => 'required|string|max:255',
        //         'middle_name' => 'nullable|string|max:255',
        //         'last_name' => 'required|string|max:255',
        //         'email' => [
        //             'required',
        //             'string',
        //             'email',
        //             'max:255',
        //             Rule::unique('users')->ignore($health_worker->id)->where(function ($query) {
        //                 return $query->where('user_role_id', 3);
        //             }),
        //         ],
        //         'contact_no' => 'nullable|string|max:255',
        //         'address' => 'nullable|string|max:255',
        //         'birthdate' => 'nullable|date_format:m/d/Y',
        //         'remarks' => 'nullable|string|max:255',
        //     ], [
        //         'email.unique' => 'The email address is already taken.',
        //         'birthdate.date_format' => 'The birthdate format is invalid. Please use MM/DD/YYYY.',
        //     ]);
        
        //     // Sanitize inputs to prevent XSS
        //     $validatedData['first_name'] = strip_tags($request->first_name);
        //     $validatedData['middle_name'] = strip_tags($request->middle_name);
        //     $validatedData['last_name'] = strip_tags($request->last_name);
        //     $validatedData['email'] = strip_tags($request->email);
        //     $validatedData['contact_no'] = strip_tags($request->contact_no);
        //     $validatedData['address'] = strip_tags($request->address);
        //     $validatedData['remarks'] = strip_tags($request->remarks);
        
        //     // Check if the email has changed
        //     if ($health_worker->email !== $validatedData['email']) {
        //         $health_worker->email = $validatedData['email'];
        //     }
        
        //     // Update other fields with sanitized data
        //     $health_worker->first_name = $validatedData['first_name'];
        //     $health_worker->middle_name = $validatedData['middle_name'];
        //     $health_worker->last_name = $validatedData['last_name'];
        //     $health_worker->contact_no = $validatedData['contact_no'];
        //     $health_worker->address = $validatedData['address'];
        
        //     // Format birthdate if present
        //     if ($request->filled('birthdate')) {
        //         $health_worker->birthdate = Carbon::createFromFormat('m/d/Y', $validatedData['birthdate'])->format('Y-m-d');
        //     } else {
        //         $health_worker->birthdate = null;
        //     }
        
        //     $health_worker->remarks = $validatedData['remarks'];
        
        //     // Save the health worker
        //     $health_worker->save();
        
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Health worker details updated successfully.',
        //         'data' => [
        //             'first_name' => htmlspecialchars($health_worker->first_name),
        //             'middle_name' => htmlspecialchars($health_worker->middle_name),
        //             'last_name' => htmlspecialchars($health_worker->last_name),
        //             'email' => htmlspecialchars($health_worker->email),
        //             'contact_no' => htmlspecialchars($health_worker->contact_no),
        //             'address' => htmlspecialchars($health_worker->address),
        //             'birthdate' => $health_worker->birthdate ? Carbon::parse($health_worker->birthdate)->format('m/d/Y') : null,
        //             'remarks' => htmlspecialchars($health_worker->remarks ?? null),
        //         ]
        //     ]);
    // }

    //EDIT WITH SANITIZE//
    public function postHealthWorker(Request $request)
    {
            $health_worker = User::findOrFail($request->id);
        
            // Validate the request
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($health_worker->id)->where(function ($query) {
                        return $query->where('user_role_id', 3);
                    }),
                ],
                'contact_no' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'birthdate' => 'nullable|date_format:m/d/Y',
                'remarks' => 'nullable|string|max:255',
            ], [
                'email.unique' => 'The email address is already taken.',
                'birthdate.date_format' => 'The birthdate format is invalid. Please use MM/DD/YYYY.',
            ]);
        
            // Sanitize inputs to prevent XSS
            $sanitizedData = [
                'first_name' => strip_tags($request->first_name),
                'middle_name' => $request->filled('middle_name') ? strip_tags($request->middle_name) : null,
                'last_name' => strip_tags($request->last_name),
                'email' => strip_tags($request->email),
                'contact_no' => $request->filled('contact_no') ? strip_tags($request->contact_no) : null,
                'address' => $request->filled('address') ? strip_tags($request->address) : null,
                'remarks' => $request->filled('remarks') ? strip_tags($request->remarks) : null,
            ];
        
            // Check if the email has changed
            if ($health_worker->email !== $sanitizedData['email']) {
                $health_worker->email = $sanitizedData['email'];
            }
        
            // Update other fields with sanitized data
            $health_worker->first_name = $sanitizedData['first_name'];
            $health_worker->middle_name = $sanitizedData['middle_name'];
            $health_worker->last_name = $sanitizedData['last_name'];
            $health_worker->contact_no = $sanitizedData['contact_no'];
            $health_worker->address = $sanitizedData['address'];
        
            // Format birthdate if present
            if ($request->filled('birthdate')) {
                $health_worker->birthdate = Carbon::createFromFormat('m/d/Y', $request->birthdate)->format('Y-m-d');
            } else {
                $health_worker->birthdate = null;
            }
        
            $health_worker->remarks = $sanitizedData['remarks'];
        
            // Save the health worker
            $health_worker->save();
        
            // Prepare response data with htmlspecialchars to prevent XSS when rendering data
            return response()->json([
                'status' => 'success',
                'message' => 'Health worker details updated successfully.',
                'data' => [
                    'first_name' => htmlspecialchars($health_worker->first_name),
                    'middle_name' => htmlspecialchars($health_worker->middle_name),
                    'last_name' => htmlspecialchars($health_worker->last_name),
                    'email' => htmlspecialchars($health_worker->email),
                    'contact_no' => htmlspecialchars($health_worker->contact_no),
                    'address' => htmlspecialchars($health_worker->address),
                    'birthdate' => $health_worker->birthdate ? Carbon::parse($health_worker->birthdate)->format('m/d/Y') : null,
                    'remarks' => htmlspecialchars($health_worker->remarks ?? null),
                ]
            ]);
            logger()->info('Health Worker ID from request:', ['id' => $request->id]);

    }
        
    // public function postnewhbw(Request $request) {
    //     return $this->postHealthWorkerForm($request->all());
    // } 

    //ADD NEW BHW
    public function postnewhbw(Request $request) {
        // Validate the input
        $validatedData = $request->validate([
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'last_name'    => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'birthdate'    => 'required|date|before:today',
            'email' => 'nullable|email|max:255',
            'contact_no'   => 'nullable|regex:/^9[0-9]{9}$/',
            'remarks'      => 'nullable|string|max:1000',
        ]);
    
        // Sanitize inputs (remove potentially harmful HTML tags)
        $sanitizedData = [
            'first_name'   => strip_tags($validatedData['first_name']),
            'middle_name'  => strip_tags($validatedData['middle_name']),
            'last_name'    => strip_tags($validatedData['last_name']),
            'address'      => strip_tags($validatedData['address']),
            'birthdate'    => $validatedData['birthdate'], // Assuming no tags
            'email' => strip_tags($validatedData['email']),
            'contact_no'   => $validatedData['contact_no'], // Assuming no tags
            'remarks'      => strip_tags($validatedData['remarks']),
        ];
    
        // Process the form submission with sanitized data
        return $this->postHealthWorkerForm($sanitizedData);
    }
    
    public function deleteHealthWorker(Request $request) {
        try {
            $user = User::findOrFail($request->id);
            if($user) {
                $user->delete();
                return response()->json(['status' => 'success', 'message' => 'Health worker successfully deleted.']);
            }
            else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong, please refresh your browser and sssstry again.']);
            }

        }
        catch(\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function healthWorkerFeminineList(Request $request) {

        $assigned_feminine_list = $this->assignedFeminineList($request->health_worker_id);
    
        $feminine_list = User::where('user_role_id', 2)
            ->where('is_active', 1)
            ->whereNotIn('id', $assigned_feminine_list->pluck('id')->toArray())
            ->select([
                'id',  
                \DB::raw("CONCAT(users.last_name, ', ', users.first_name) AS full_name"), 'address' // Include address field
            ])
            ->get();
    
        $data = [
            'assigned_feminine_list' => $assigned_feminine_list,
            'feminine_list' => $feminine_list
        ];
    
        return response()->json($data);
    }

    public function postAssignFeminine(Request $request) {

        if($request['feminine_id'] && count($request['feminine_id']) != 0) {
            foreach($request['feminine_id'] as $user_id) {
                $post_assign_health_worker = FeminineHealthWorkerGroup::firstOrCreate([
                    'feminine_id' => $user_id,
                    'health_worker_id' => $request->id
                ]);
            }
            return response()->json(['status' => 'success', 'message' => count($request['feminine_id']).' Feminine successfully assigned.']);
        }
        else {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one feminine.']);
        }
    }

    public function deleteAssignFeminine(Request $request) {
        try {
            $delete_assigned_feminine = FeminineHealthWorkerGroup::findOrFail($request->id);
            $health_worker_id = $delete_assigned_feminine->health_worker_id;

            $delete_assigned_feminine->delete();

            return response()->json(['status' => 'success', 'message' => 'Feminine successfully deleted.', 'updated_count' => count($this->assignedFeminineList($health_worker_id))]);
        }
        catch(\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function healthWorkerData() {
        $health_worker_arr = User::where('user_role_id', 3)
            ->orderBy('last_name', 'ASC')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'address', 'email', 'contact_no', 'birthdate', 'is_active', 'remarks'])
            ->toArray();
    
        $row_count = 0;
        foreach ($health_worker_arr as $health_worker_key => $health_worker) {
            $assigned_feminine_list = $this->assignedFeminineList($health_worker['id'])->toJson();
    
            $full_name = $health_worker['last_name'] . ', ' . $health_worker['first_name'] . ' ' . $health_worker['middle_name'];
    
            $health_worker_arr[$health_worker_key]['row_count'] = ++$row_count;
            $health_worker_arr[$health_worker_key]['full_name'] = $full_name;
            $health_worker_arr[$health_worker_key]['is_active'] = '<span class="text-' . ($health_worker['is_active'] == 1 ? 'success' : 'danger') . '"><strong>&bull;</strong> ' . ($health_worker['is_active'] == 1 ? 'Active' : 'Inactive') . '</span>';
            
            if ($health_worker['is_active'] == 1) {
                $health_worker_arr[$health_worker_key]['is_active_status'] = '<span class="text-success"><strong>&bull;</strong> Verified</span>';
            } else {
                $health_worker_arr[$health_worker_key]['is_active_status'] = '<button type="button" class="btn btn-sm btn-success verify_account" id="notif_' . $health_worker['id'] . '" data-id="' . $health_worker['id'] . '" data-full_name="' . $full_name . '" ><i class="fa-solid fa-user-check"></i> Verify</button>';
            }
    
            $health_worker_arr[$health_worker_key]['assigning_action'] = '
                <button type="button" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#assignFeminineModal" 
                    data-health_worker_name="' . $full_name . '"
                    data-id="' . $health_worker['id'] . '">
                        <i class="fa-solid fa-user-tag"></i> Assign
                </button>
            ';
    
            $health_worker_arr[$health_worker_key]['action'] = '
                <button type="button" class="btn btn-sm btn-secondary"
                    data-full_name="' . $full_name . '"
                    data-email="' . ($health_worker['email'] ?? 'N/A') . '"
                    data-contact_no="' . ($health_worker['contact_no'] ?? '') . '"
                    data-address="' . $health_worker['address'] . '"
                    data-birthdate="' . ($health_worker['birthdate'] ? date('F j, Y', strtotime($health_worker['birthdate'])) : 'N/A') . '"
                    data-is_active="' . $health_worker['is_active'] . '"
                    data-remarks="' . ($health_worker['remarks'] ?? 'N/A') . '"
                    data-assigned_feminine_list="' . htmlspecialchars(json_encode($this->assignedFeminineList($health_worker['id']))) . '"
                    data-toggle="modal" data-target="#viewHealthWorkerModal">
                        <i class="fa-solid fa-magnifying-glass"></i> View
                </button>
                
                <button type="button" class="btn btn-sm btn-primary"
                    data-id="' . $health_worker['id'] . '"
                    data-first_name="' . $health_worker['first_name'] . '"
                    data-last_name="' . $health_worker['last_name'] . '"
                    data-middle_name="' . $health_worker['middle_name'] . '"
                    data-email="' . $health_worker['email'] . '"
                    data-contact_no="' . $health_worker['contact_no'] . '"
                    data-address="' . $health_worker['address'] . '"
                    data-birthdate="' . ($health_worker['birthdate'] ? date('m/d/Y', strtotime($health_worker['birthdate'])) : null) . '"
                    data-remarks="' . ($health_worker['remarks'] ?? null) . '"
                    data-toggle="modal" data-target="#editHealthWorkerModal">
                        <i class="fa-solid fa-user-pen"></i> Edit
                </button>
    
                <button type="button" class="btn btn-sm btn-danger delete_record" data-id="' . $health_worker['id'] . '"><i class="fa-solid fa-trash"></i> Delete</button>
            ';
        }
    
        return response()->json([
            'data' => $health_worker_arr,
            'recordsFiltered' => count($health_worker_arr),
            'recordsTotal' => count($health_worker_arr)
        ]);
    }    

    private function assignedFeminineList($health_worker_id) {
        return FeminineHealthWorkerGroup::where('health_worker_id', $health_worker_id)
            ->with('feminine:id,last_name,first_name,address') // Include address field
            ->get(['feminine_id', 'feminine_health_worker_groups.id as feminine_health_worker_group_id'])
            ->map(function ($item) {
                return [
                    'id' => $item->feminine->id,
                    'feminine_health_worker_group_id' => $item->feminine_health_worker_group_id,
                    'full_name' => $item->feminine->full_name(),
                    'address' => $item->feminine->address // Include address in the array
                ];
            });
    }
   
    public function verifyHealthWorker(Request $request)
    {
        $id = $request->input('id');

        // Fetch the user with the provided ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Health Worker not found'], 404);
        }

        // Check if the user is a Health Worker
        if ($user->user_role_id != 3) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        // Verify the Health Worker
        $user->is_active = 1;
        $user->save();

        return response()->json(['message' => 'Health Worker verified successfully']);
    }
}
