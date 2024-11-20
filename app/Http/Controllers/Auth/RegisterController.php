<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Session;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // protected function validator(array $data)
    // {
    //     $rules = [
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'address' => ['required', 'string', 'max:255'],
    //         'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:6', 'confirmed'],
    //         'birthdate' => ['required', 'date', 'before:today'],
    //         'contact_no' => ['numeric', 'nullable', 'regex:/^\d{10,11}$/', 'unique:users,contact_no', 'required_if:email,null'],
    //         'role' => ['required', Rule::in(['Health Worker', 'Feminine'])],
    //     ];

    //     if ($data['role'] === 'Feminine') {
    //         $rules['menstruation_status'] = ['required', 'boolean'];
    //     }

    //     return Validator::make($data, $rules, [
    //         'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
    //         'contact_no.unique' => 'The contact number has already been taken.',
    //         'unique' => 'The :attribute field has already been taken.'
    //     ]);
    // }

    protected function validator(array $data)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255', 'bail', function($attribute, $value, $fail) {
                $sanitizedValue = htmlspecialchars(strip_tags($value));
                if ($this->containsMaliciousScript($sanitizedValue)) {
                    \Log::warning('Malicious script detected in user registration form.', ['value' => $value]);
                    $fail('Malicious script detected in this field. Your actions have been logged for security purposes.');
                }
            }],
            'middle_name' => ['nullable', 'string', 'max:255', function($attribute, $value, $fail) {
                $sanitizedValue = htmlspecialchars(strip_tags($value));
                if ($this->containsMaliciousScript($sanitizedValue)) {
                    \Log::warning('Malicious script detected in user registration form.', ['value' => $value]);
                    $fail('Malicious script detected in this field. Your actions have been logged for security purposes.');
                }
            }],
            'last_name' => ['required', 'string', 'max:255', 'bail', function($attribute, $value, $fail) {
                $sanitizedValue = htmlspecialchars(strip_tags($value));
                if ($this->containsMaliciousScript($sanitizedValue)) {
                    \Log::warning('Malicious script detected in user registration form.', ['value' => $value]);
                    $fail('Malicious script detected in this field. Your actions have been logged for security purposes.');
                }
            }],
            'address' => ['required', 'string', 'max:255', 'bail', function($attribute, $value, $fail) {
                $validAddresses = [
                    'Tarong Madridejos Cebu',
                    'Bunakan Madridejos Cebu',
                    'Kangwayan Madridejos Cebu',
                    'Kaongkod Madridejos Cebu',
                    'Kodia Madridejos Cebu',
                    'Maalat Madridejos Cebu',
                    'Malbago Madridejos Cebu',
                    'Mancilang Madridejos Cebu',
                    'Pili Madridejos Cebu',
                    'Poblacion Madridejos Cebu',
                    'San Agustin Madridejos Cebu',
                    'Tabagak Madridejos Cebu',
                    'Talangnan Madridejos Cebu',
                    'Tugas Madridejos Cebu',
                ];
                if (!in_array($value, $validAddresses)) {
                    $fail('The selected address is invalid.');
                }
            }],    
            'email' => ['nullable', 'string', 'email:rfc,dns', 'email', 'max:255', 'unique:users','regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/', 'bail', function($attribute, $value, $fail) {
                $sanitizedValue = htmlspecialchars(strip_tags($value));
                if ($this->containsMaliciousScript($sanitizedValue)) {
                    \Log::warning('Malicious script detected in user registration form.', ['value' => $value]);
                    $fail('Malicious script detected in this field. Your actions have been logged for security purposes.');
                }
                // Ensure the email is a Gmail address
                if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $value)) {
                    $fail('The email must be a Gmail address.(nelbanbetache@gmail.com)');
                }
            }],
            'password' => [
                'required', 'string', 'min:8', 'confirmed', 
                'regex:/[A-Z]/',     // at least one uppercase letter
                'regex:/[a-z]/',     // at least one lowercase letter
                'regex:/[0-9]/',     // at least one digit
                'regex:/[@$!%*#?&]/', // at least one special character
                function($attribute, $value, $fail) {
                    if ($this->containsMaliciousScript($value)) {
                        \Log::warning('Malicious script detected in user registration form.', ['value' => $value]);
                        $fail('Malicious script detected in this field. Your actions have been logged for security purposes.');
                    }
                }
            ],
            'birthdate' => ['required', 'date', 'before:today'],
            'contact_no' => ['nullable', 'regex:/^\d{10,11}$/', 'unique:users,contact_no', 'required_without:email'],
            'role' => ['required', Rule::in(['Health Worker', 'Feminine'])],
            'captcha' => 'required|captcha',
            'terms' => 'accepted',
        ];
    
        if ($data['role'] === 'Feminine') {
            $rules['menstruation_status'] = ['required', 'boolean'];
        }
    
        return Validator::make($data, $rules, [
            'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
            'contact_no.unique' => 'The contact number has already been taken.',
            'unique' => 'The :attribute field has already been taken.',
            'captcha.required' => 'The captcha field is required.',
            'captcha.captcha' => 'Invalid captcha.',
            'terms' => 'Please read the terms and conditions',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character. (e.g., @$!%*#?&)',
        ]);
    }
    
    /**
     * Function to check for malicious scripts in input values.
     */
    protected function containsMaliciousScript($value)
    {
        $patterns = [
            '/<script\b[^>]*>(.*?)<\/script>/i',        // script tags
            '/on\w+=".*?"/i',                           // event handlers like onclick
            '/javascript\s*:\s*/i',                     // javascript protocol
            '/<iframe.*?src\s*=\s*"javascript:.*?".*?>/i', // iframe with javascript
            '/<img.*?onerror=.*?>/i',                   // image tag with onerror
            '/<body.*?onload=.*?>/i',                   // body tag with onload
            '/<svg.*?onload=.*?>/i',                    // SVG onload
            '/<link.*?onload=.*?>/i',                   // link tag with onload
            '/;\s*alert\s*\(/i',                        // alert function
            '/;\s*prompt\s*\(/i',                       // prompt function
            '/;\s*eval\s*\(/i',                         // eval function
            '/;\s*document\.cookie\s*\=/i',             // cookie access
            '/\balert\s*\(/i',                          // generic alert
            '/\beval\s*\(/i',                           // generic eval
            '/\bconsole\.log\s*\(/i',                   // console log
            '/\/\*.*?\*\//s',                           // multi-line comments
            '/<style.*?<\/style>/i',                    // style tags
            '/\bon[a-z]+\s*=\s*"/i',                    // event attributes like onload
            '/\s*src\s*=\s*["\']?\s*javascript:[^"\']*["\']?\s*/i' // catch javascript in src attribute
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true; // Malicious script detected
            }
        }
    
        return false; // No malicious script found
    }
    
     

    protected function create(array $data)
    {
        $role = $data['role'] === 'Health Worker' ? 3 : 2;
    
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'address' => $data['address'] ?? null,
            'birthdate' => date('Y-m-d', strtotime($data['birthdate'])),
            'password' => Hash::make($data['password']),
            'menstruation_status' => $data['role'] === 'Feminine' ? $data['menstruation_status'] : 0, // Set to 0 for Health Workers
            'user_role_id' => $role,
            'is_active' => false,
        ]);
    }

    protected function registered() 
    {
        Session::flush();
        Auth::logout();
        Session::regenerate();
    
        Session::flash('post-register', 'Registration complete! Please wait for admin verification. You’ll receive a notification once verified.');
    
        $user = Auth::user();
        
        if ($user) {
            // Send an email to the user informing them about the admin verification
            Mail::to($user->email)->send(new AdminVerificationMail($user));
        }
    
        return redirect()->route('login.page');
    }
    

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('inverse')]);
    }
    
    // public function showRegistrationForm()
    // {
    //     session(['show_terms' => true]); // Show terms popup
    //     return view('auth.register');
    // }
    public function showRegistrationForm()
    {
        session(['show_terms' => true]);
        return response()->view('auth.register')->header('X-Frame-Options', 'DENY');
    }
    
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
        ]);
    }

}