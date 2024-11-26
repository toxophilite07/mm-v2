<?php

namespace App\Http\Controllers\Auth; // Only one namespace declaration
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Ensure this line is present
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth; // Import Auth facades
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Carbon\Carbon; // Make sure Carbon is imported
use App\Models\User; 

class ForgotPasswordController extends Controller {

    public function index() {
        if (Auth::check()) return redirect()->back();
        return view('auth.forgot_password');
    }

    // public function postForgotPassword(Request $request) {
    //     try {
    //         $check_validation = Validator::make($request->all(), [ 
    //             'email' => 'required|email|exists:users'
    //         ]);

    //         if ($check_validation->fails()) return back()->with('post-forgot-password-error', 'Email address does not exist, please try again.');

    //         $token = Str::random(64);
    //         $user = DB::table('users')
    //             ->where('email', $request->email)
    //             ->get(['email', 'first_name'])->last();

    //         DB::table('password_resets')->insert([
    //             'email' => $user->email, 
    //             'token' => $token, 
    //             'created_at' => Carbon::now()
    //         ]);

    //         Mail::send('email.forgot_password_mail', ['token' => $token, 'user' => $user], function($message) use ($request, $user) {
    //             $message->from('nelbanbetache@gmail.com', 'Menstrual Monitoring App')
    //                 ->to($user->email)
    //                 ->subject('Reset Password');
    //         });

    //         return back()->with('post-forgot-password', 'We have sent you a password reset link, please check your email.');
    //     } catch (Exception $e) {
    //         \Log::error('Forgot password error: ' . $e->getMessage());
    //         return back()->with('post-forgot-password-error', 'Something went wrong!');
    //     }
    // }

    public function postForgotPassword(Request $request) {
        try {
            // Validate the request
            $check_validation = Validator::make($request->all(), [
                'email' => 'required|email|exists:users'
            ]);
    
            if ($check_validation->fails()) {
                return back()->with('post-forgot-password-error', 'Email address does not exist, please try again.');
            }
    
            // Get the user information
            $user = DB::table('users')
                ->where('email', $request->email)
                ->select('email', 'first_name')
                ->first();
    
            // Check if a reset request already exists
            $resetRequest = DB::table('password_resets')
                ->where('email', $request->email)
                ->first();
    
            // If a reset request exists, check the created_at time
            if ($resetRequest) {
                $createdAt = Carbon::parse($resetRequest->created_at);
                // Use isFuture() method to check if the time is in the future
                if ($createdAt->addHours(24)->isFuture()) {
                    return back()->with('post-forgot-password-error', 'To enhance your account security, password reset requests are limited to once every 24 hours.');
                }
            }
    
            // Generate a new token
            $token = Str::random(64);
    
            // Insert or update the password reset record
            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => Carbon::now()]
            );
    
            // Send the reset email
            Mail::send('email.forgot_password_mail', ['token' => $token, 'user' => $user], function($message) use ($user) {
                $message->from('nelbanbetache@gmail.com', 'Menstrual Monitoring App')
                    ->to($user->email)
                    ->subject('Reset Password');
            });
    
            return back()->with('post-forgot-password', 'We have sent you a password reset link, please check your email.');
        } catch (Exception $e) {
            \Log::error('Forgot password error: ' . $e->getMessage());
            return back()->with('post-forgot-password-error', 'Something went wrong!');
        }
    }

    public function sendResetLinkSms(Request $request)
    {
        $request->validate([
            'contact_no' => 'required|digits:10|exists:users,contact_no',
        ]);
    
        $contact_no = '+63' . $request->contact_no;
    
        // Check if a reset request already exists
        $user = User::where('contact_no', $request->contact_no)->first();
        if (!$user) {
            return back()->with('error', 'Phone number is not registered.');
        }
    
        // Check if a reset request was made within the last 24 hours
        $existingReset = DB::table('password_resets')
            ->where('email', $user->email)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->first();
    
        if ($existingReset) {
            return back()->with('error', 'You can request a password reset link only once every 24 hours.');
        }
    
        $token = Str::random(64);
    
        // Save the token in the database
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );
    
        // Generate the reset link
        $resetLink = route('password.reset', ['token' => $token]);
    
        // Send the reset link via SMS using Sinch
        try {
            $sinchAppKey = env('SINCH_APP_KEY');
            $sinchAppSecret = env('SINCH_APP_SECRET');
            $sinchUrl = 'https://sms.api.sinch.com/xms/v1/' . env('SINCH_SERVICE_PLAN_ID') . '/batches';
    
            $payload = [
                'from' => env('SINCH_SENDER_ID'),
                'to' => [$contact_no],
                'body' => "Reset your password using the following link: $resetLink",
            ];
    
            $client = new \GuzzleHttp\Client();
            $response = $client->post($sinchUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$sinchAppKey:$sinchAppSecret"),
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);
    
            if ($response->getStatusCode() !== 201) {
                throw new \Exception('Failed to send SMS. Status Code: ' . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            \Log::error('SMS sending failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send the reset link. Please try again.');
        }
    
        return back()->with('success', 'Password reset link sent successfully via SMS.');
    }
     
    public function getResetPassword($token) 
{
    if (Auth::check()) return redirect()->back();

    $password_reset_request = DB::table('password_resets')->where('token', $token)->first();

    // Check if the token exists
    if (!$password_reset_request) abort(404);

    // Check if the token is expired
    $createdAt = Carbon::parse($password_reset_request->created_at);
    if ($createdAt->addMinutes(3)->isPast()) {
        return redirect('/forgot-password')->with('post-reset-password-error', 'This password reset link has expired. Please request a new one.');
    }

    $user = User::where('email', $password_reset_request->email)
        ->select(['email', 'first_name'])
        ->first();

    return view('auth.reset_password', compact('token', 'user'));
}


public function postResetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required'
    ]);

    $check_request = DB::table('password_resets')
        ->where([
            'email' => $request->email, 
            'token' => $request->token
        ])->first();

    // Check if the token is valid
    if (!$check_request) {
        return back()->with('post-reset-password-error', 'Invalid or expired token!');
    }

    // Check if the token has expired
    $createdAt = Carbon::parse($check_request->created_at);
    if ($createdAt->addHours(24)->isPast()) {
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        return back()->with('post-reset-password-error', 'This password reset link has expired.');
    }

    // Update the user's password
    User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

    // Delete the token after use
    DB::table('password_resets')->where(['email' => $request->email])->delete();

    return redirect('/login')->with('post-reset-password', 'Your password has been changed!');
}

}
