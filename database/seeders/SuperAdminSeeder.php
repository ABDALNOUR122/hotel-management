<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => 'Super Admin',
            'email'             => 'admin@system.com',
            'join_date'         => Carbon::now(),
            'phone_number'      => '0500000000',
            'role_name'         => 'Admin',
            'position'          => 'General Manager',
            'department'        => 'Administration',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('password123'),
        ]);
    }
}