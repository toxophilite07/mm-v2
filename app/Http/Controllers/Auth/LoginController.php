<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
        $this->middleware('guest')->except('logout');

        \Artisan::call('optimize:clear');
    }

    public function login(Request $request) {
        $credentials = $request->only('password');
        $multi_user_field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'contact_no';
    
        $credentials[$multi_user_field] = $request->input($multi_user_field);
    
        if ($this->auth->attempt($credentials)) {
            $user = $this->auth->user();
    
            if($user->user_role_id == 1) {
                return redirect()->route('admin.dashboard');
            }
            elseif($user->user_role_id == 3) {  // Health Worker
                if($user->is_active == 1) {
                    return redirect()->route('health-worker.dashboard');
                } else {
                    $this->logout($request);
                    Session::flash('account-verification-error', 'Your account is not verified by the admin yet. Please come back later.');
                    return redirect()->route('login.page');
                }
            }
            else {  // Feminine user
                if($user->is_active == 1) {
                    return redirect()->route('user.dashboard');
                }
                else {
                    $this->logout($request);
                    Session::flash('account-verification-error', 'Your account is not verified by the admin yet. Please come back later.');
                    return redirect()->route('login.page');
                }
            }
        }
        else {
            $this->logout($request);
            Session::flash('login-error', 'Invalid user credential, please try again.');
            return redirect()->route('login.page');
        }
    }
}
