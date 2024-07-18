<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'MCC',
            'last_name' => 'Admin',
            'email' => 'mcc@admin.com',
            'user_role_id' => 1, // admin
            'menstruation_status' => 0,
            'password' => Hash::make('mcc@admin.com'),
            'is_active' => 1, // by default, admin is active
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
