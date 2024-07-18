<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

use App\Models\User; 

class ForgotPasswordController extends Controller {

    public function index() {

        if(Auth::check()) return redirect()->back();

        return view('auth.forgot_password');
    }

    public function postForgotPassword(Request $request) {

        try {
            $check_validation = Validator::make($request->all(), [ 
                'email' => 'required|email|exists:users'
            ]);

            if($check_validation->fails()) return back()->with('post-forgot-password-error', 'Email address does not exist, please try again.');
    
            $token = Str::random(64);
            $user = DB::table('users')
                ->where('email', $request->email)
                ->get(['email', 'first_name'])->last();

            DB::table('password_resets')->insert([
                'email' => $user->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
    
            Mail::send('email.forgot_password_mail', ['token' => $token, 'user' => $user], function($message) use($request, $user) {
                $message->from('noreply@gmail.com', 'MM-App forgot password')
                    ->to($user->email)
                    ->subject('Reset Password');
            });
    
            return back()->with('post-forgot-password', 'We have sent you a password reset link, please check your email.');
        }
        catch(Exception $e) {
            return back()->with('post-forgot-password-error', 'Something went wrong!');
        }
    }

    public function getResetPassword($token) {

        if(Auth::check()) return redirect()->back();

        $password_reset_request = DB::table('password_resets')->where('token', $token)->first();
        if(!$password_reset_request) abort(404);

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

        if(!$check_request) return back()->with('post-reset-password-error', 'Invalid token!');

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('post-reset-password', 'Your password has been changed!');
    }
}
