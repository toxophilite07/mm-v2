<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\MenstruationPeriod;
use App\Models\FeminineHealthWorkerGroup;

trait UserRegistrationTrait
{
    public function postForm($form_data)
    {

        try {
            $check_validation = Validator::make($form_data, [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'nullable|email|max:100|unique:users,email',
                'menstruation_status' => 'required|boolean',
                'last_period_date' => 'required|date',
                'birthdate' => 'required|date|before:today',
                'contact_no' => ['numeric', 'nullable', 'regex:/^\d{10,11}$/', 'unique:users,contact_no', 'required_if:email,null'],
            ], [
                'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
                'contact_no.unique' => 'The contact number has already been taken.',
                'unique' => 'The :attribute field has already been taken.'
            ]);

            if ($check_validation->fails()) return response()->json(['success' => false, 'message' => $check_validation->errors()->first()], 500);


            $user_data = isset($form_data['id'])
                ? User::findOrFail($form_data['id'])
                : new User;

            $user_data->fill([
                'first_name' => $form_data['first_name'],
                'middle_name' => $form_data['middle_name'] ?? null,
                'last_name' => $form_data['last_name'],
                'address' => $form_data['address'] ?? null,
                'email' => $form_data['email'] ?? null,
                'contact_no' => $form_data['contact_no'] ?? null,
                'birthdate' => date('Y-m-d', strtotime($form_data['birthdate'])),
                'menstruation_status' => $form_data['menstruation_status'] ?? null,
                'user_role_id' => 2, // 2 = user feminine and default role
                'is_active' => 1, // since the admin/health worker registered the new user, then it is logically active or verified
                'remarks' => $form_data['remarks'] ?? null,
            ]);

            if (!isset($form_data['id'])) $user_data->fill(['password' => Hash::make('password')]); // if new user, set default password
            $user_data->save();

            if ($user_data) {
                if (isset($form_data['edit_menstruation_period_id'])) {
                    $post_menstruation_period = MenstruationPeriod::findOrFail($form_data['edit_menstruation_period_id']);
                    $post_menstruation_period->menstruation_date = date('Y-m-d', strtotime($form_data['last_period_date']));
                    $post_menstruation_period->save();
                } else {
                    $post_menstruation_period = MenstruationPeriod::firstOrCreate([
                        'user_id' => $user_data->id,
                        'menstruation_date' => date('Y-m-d', strtotime($form_data['last_period_date'])),
                    ]);
                }
            }

            // check if bhw is the one who registered the user, if so then assign the user to the bhw
            $bhw_id = auth()->user()->user_role_id === 3 ? auth()->user()->id : null;
            if ($bhw_id) {
                $feminine_health_worker_group = FeminineHealthWorkerGroup::firstOrCreate([
                    'feminine_id' => $user_data->id,
                    'health_worker_id' => $bhw_id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'New feminine user successfully saved.',
                'feminine_count' => $this->feminineCount()
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function postHealthWorkerForm($form_data)
    {
        try {
            $check_validation = Validator::make($form_data, [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'nullable|email|max:100|unique:users,email',
                'birthdate' => 'required|date|before:today',
                'contact_no' => ['numeric', 'nullable', 'regex:/^\d{10,11}$/', 'unique:users,contact_no', 'required_if:email,null'],
            ], [
                'contact_no.regex' => 'The contact number must be 10 or 11 digits.',
                'contact_no.unique' => 'The contact number has already been taken.',
                'unique' => 'The :attribute field has already been taken.'
            ]);

            if ($check_validation->fails()) return response()->json(['success' => false, 'message' => $check_validation->errors()->first()], 500);

            $user_data = isset($form_data['id'])
                ? User::findOrFail($form_data['id'])
                : new User;

            $user_data->fill([
                'first_name' => $form_data['first_name'],
                'middle_name' => $form_data['middle_name'] ?? null,
                'last_name' => $form_data['last_name'],
                'address' => $form_data['address'] ?? null,
                'email' => $form_data['email'],
                'contact_no' => $form_data['contact_no'],
                'birthdate' => date('Y-m-d', strtotime($form_data['birthdate'])),
                'menstruation_status' => 2, // 2 = not applicable
                'user_role_id' => 3, // 3 = barangay health worker and default role
                'is_active' => 1, // since the admin registered the new health worker, then it is logically active or verified
                'remarks' => $form_data['remarks'] ?? null,
            ]);

            if (!isset($form_data['id'])) $user_data->fill(['password' => Hash::make('password')]); // if new user, set default password
            $user_data->save();

            return response()->json([
                'success' => true,
                'message' => !isset($form_data['id']) ? 'New health worker successfully saved.' : 'Health worker successfully updated.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function feminineCount()
    {
        return [
            'feminine_count' => User::where('user_role_id', 2)->count(),
            'active_feminine_count' => User::where('user_role_id', 2)->where('menstruation_status', 1)->count(),
            'inactive_feminine_count' => User::where('user_role_id', 2)->where('menstruation_status', 0)->count(),
        ];
    }

    private function healthWorkerFeminineCount()
    {
        $active = FeminineHealthWorkerGroup::join('users', 'users.id', '=', 'feminine_health_worker_groups.feminine_id')
            ->where('feminine_health_worker_groups.health_worker_id', Auth::user()->id)
            ->where('users.menstruation_status', 1)
            ->count();

        $inactive = FeminineHealthWorkerGroup::join('users', 'users.id', '=', 'feminine_health_worker_groups.feminine_id')
            ->where('feminine_health_worker_groups.health_worker_id', Auth::user()->id)
            ->where('users.menstruation_status', 0)
            ->count();

        return [
            'active_feminine_count' => $active,
            'inactive_feminine_count' => $inactive,
        ];
    }
}
