<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log; // Import Log
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 3; // Limit to 3 login attempts
    protected $decayMinutes = 5; // Lockout time in minutes

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $throttleKey = $this->getThrottleKey($request);
        
        // Debugging: Log throttle attempts and key
        Log::info("Throttle Key: $throttleKey");
        Log::info("Current Attempts: " . RateLimiter::attempts($throttleKey));

        // Check if too many attempts have been made
        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts)) {
            $remainingTime = RateLimiter::availableIn($throttleKey);
            $formattedTime = gmdate("i:s", $remainingTime);
            Session::flash('login-error', "Too many login attempts. Please wait $formattedTime before trying again.");
            return redirect()->route('login.page');
        }
        // Check hCaptcha response
        // $hCaptchaResponse = $request->input('h-captcha-response');
        // if (!$hCaptchaResponse || !$this->verifyHCaptcha($hCaptchaResponse)) {
        //     Session::flash('captcha-error', "Please verify that you are not a robot.");
        //     return redirect()->route('login.page');
        // }

        $credentials = $request->only('password');
        $multi_user_field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'contact_no';
        $credentials[$multi_user_field] = $request->input($multi_user_field);
        $remember = $request->filled('remember');

        // Attempt to log the user in
        if ($this->auth->attempt($credentials, $remember)) {
            // Clear the attempts counter if login is successful
            RateLimiter::clear($throttleKey);

            $user = $this->auth->user();

            // Redirect based on user roles
            if ($user->user_role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->user_role_id == 3) {
                if ($user->is_active == 1) {
                    return redirect()->route('health-worker.dashboard');
                } else {
                    $this->logout($request);
                    Session::flash('account-verification-error', 'Your account is awaiting admin verification. You’ll be notified once it’s approved.');
                    return redirect()->route('login.page');
                }
            } else {
                if ($user->is_active == 1) {
                    return redirect()->route('user.dashboard');
                } else {
                    $this->logout($request);
                    Session::flash('account-verification-error', 'Your account is awaiting admin verification. You’ll be notified once it’s approved.');
                    return redirect()->route('login.page');
                }
            }
        } else {
            // Increment attempts after each failed login
            RateLimiter::hit($throttleKey, $this->decayMinutes * 60);

            $currentAttempts = RateLimiter::attempts($throttleKey);
            $remainingAttempts = $this->maxAttempts - $currentAttempts;

            // Debugging: Log remaining attempts and throttle status
            Log::info("Remaining Attempts: $remainingAttempts");
            Log::info("Attempts Left: " . ($this->maxAttempts - RateLimiter::attempts($throttleKey)));

            if ($remainingAttempts <= 0) {
                // Lockout condition
                $remainingTime = RateLimiter::availableIn($throttleKey);
                $formattedTime = gmdate("i:s", $remainingTime);
                Session::flash('login-error', "Too many login attempts. Please wait $formattedTime before trying again.");
            } else {
                // Remaining attempts
                Session::flash('login-error', "Invalid credentials. You have $remainingAttempts attempt(s) left.");
            }

            return redirect()->route('login.page');
        }
    }

    // Function to get throttle key for rate limiting
    protected function getThrottleKey(Request $request)
    {
        // Use the email or phone number with IP address for throttle key
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    // protected function verifyHCaptcha($response)
    // {
    //     $secretKey = env('HCAPTCHA_SECRET_KEY'); // Ensure you have this in your .env file
    //     $verificationResponse = Http::asForm()->post('https://hcaptcha.com/siteverify', [
    //         'secret' => $secretKey,
    //         'response' => $response,
    //     ]);

    //     return $verificationResponse->json()['success'] ?? false;
    // }
    
}
