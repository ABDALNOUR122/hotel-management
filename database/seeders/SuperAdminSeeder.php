<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'role_name'         => 'Super Admin',
            'avatar'            => null,
            'position'          => 'General Manager',
            'department'        => 'Management',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('password123'),
        ]);
    }
}