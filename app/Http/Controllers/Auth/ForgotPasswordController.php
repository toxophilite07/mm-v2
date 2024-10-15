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
    
    public function getResetPassword($token) {
        if (Auth::check()) return redirect()->back();

        $password_reset_request = DB::table('password_resets')->where('token', $token)->first();
        if (!$password_reset_request) abort(404);

        $user = User::where('email', $password_reset_request->email)
            ->select(['email', 'first_name'])
            ->first();

        return view('auth.reset_password', compact('token', 'user'));
    }

    public function postResetPassword(Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $check_request = DB::table('password_resets')
            ->where([
                'email' => $request->email, 
                'token' => $request->token
            ])->get()->last();

        if (!$check_request) return back()->with('post-reset-password-error', 'Invalid token!');

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('post-reset-password', 'Your password has been changed!');
    }
}
