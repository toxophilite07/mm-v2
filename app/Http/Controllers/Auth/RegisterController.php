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
use Session;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'birthdate' => ['required', 'date', 'before:today'],
            'contact_no' => ['numeric', 'nullable', 'regex:/^\d{10,11}$/', 'unique:users,contact_no', 'required_if:email,null'],
            'role' => ['required', Rule::in(['Health Worker', 'Feminine'])],
        ];

        if ($data['role'] === 'Feminine') {
            $rules['menstruation_status'] = ['required', 'boolean'];
        }

        return Validator::make($data, $rules, [
            'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
            'contact_no.unique' => 'The contact number has already been taken.',
            'unique' => 'The :attribute field has already been taken.'
        ]);
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

    protected function registered() {
        Session::flush();
        Auth::logout();

        Session::flash('post-register', 'Registration completed! Please wait for the admin to verify your account.');

        return redirect()->route('login.page');
    }
}