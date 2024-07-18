<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use App\Models\MenstruationPeriod;
use App\Models\FeminineHealthWorkerGroup;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function signupNotification() {
        return User::where('is_active', 0)
            ->where('user_role_id', 2)
            ->latest()
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'email', 'menstruation_status', 'menstruation_status']);
    }

    public function newMenstrualPeriodNotification() {
        return MenstruationPeriod::join('users', 'users.id', '=', 'menstruation_periods.user_id')
            ->where('users.user_role_id', 2)
            ->where('users.is_active', 1)
            ->where('menstruation_periods.is_seen', 0)
            ->get([
                'menstruation_periods.id',
                'users.id as user_id',
                \DB::raw("DATE_FORMAT(menstruation_periods.menstruation_date, '%b %e, %Y') as formatted_menstruation_date"),
                'users.first_name',
                'users.last_name',
                'users.middle_name']);
    }

    public function newMenstrualPeriodNotificationForHealthWorker() {
        return MenstruationPeriod::join('users', 'users.id', '=', 'menstruation_periods.user_id')
            ->join('feminine_health_worker_groups', 'feminine_health_worker_groups.feminine_id', '=', 'menstruation_periods.user_id')
            ->where('feminine_health_worker_groups.health_worker_id', Auth::user()->id)
            ->where('users.user_role_id', 2)
            ->where('users.is_active', 1)
            ->where('menstruation_periods.is_seen', 0)
            ->get([
                'menstruation_periods.id',
                'users.id as user_id',
                \DB::raw("DATE_FORMAT(menstruation_periods.menstruation_date, '%b %e, %Y') as formatted_menstruation_date"),
                'users.first_name',
                'users.last_name',
                'users.middle_name']);
    }
}
