<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->datetime('join_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('role_name', ['Admin', 'Manager', 'Staff'])->default('Staff'); 
            $table->enum('position', [
                'General Manager', 
                'Receptionist', 
                'Housekeeper', 
                'Chef', 
                'Waiter', 
                'Accountant', 
                'Security Officer'
            ])->default('Receptionist');
            $table->enum('department', [
                'Administration', 
                'Front Office', 
                'Housekeeping', 
                'Food & Beverage', 
                'Finance & Accounting', 
                'Security'
            ])->default('Housekeeping'); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
