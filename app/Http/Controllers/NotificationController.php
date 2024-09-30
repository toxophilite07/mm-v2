<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function checkNotifications()
    {
        $newFemaleUsers = User::where('user_role_id', 2)
            ->where('created_at', '>', now()->subMinutes(30))
            ->count();

        $newHealthWorkers = User::where('user_role_id', 3)
            ->where('created_at', '>', now()->subMinutes(30))
            ->count();

        return response()->json([
            'new_female_users' => $newFemaleUsers,
            'new_health_workers' => $newHealthWorkers,
        ]);
    }
}
