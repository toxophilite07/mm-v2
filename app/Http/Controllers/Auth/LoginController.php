<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard; // Make sure this is included
use Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $auth; // Declare the auth property

    public function __construct(Guard $auth) {
        $this->auth = $auth; // Assign the injected Guard instance to the property
        $this->middleware('guest')->except('logout');

        \Artisan::call('optimize:clear');
    }

    public function login(Request $request) {
        $credentials = $request->only('password');
        $multi_user_field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'contact_no';
    
        $credentials[$multi_user_field] = $request->input($multi_user_field);

        // Check if the "Remember Me" checkbox is selected
        $remember = $request->filled('remember');
    
        if ($this->auth->attempt($credentials, $remember)) {
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
