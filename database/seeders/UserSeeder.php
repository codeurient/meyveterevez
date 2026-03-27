<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // NORMAL USER
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@example.com',
            'email_verified_at' => Carbon::now(),

            'password' => Hash::make('11111111'),

            'phone_verified_at' => null,

            'current_role' => 'user',

            'status' => 'active',


            'avatar' => null,
            'bio' => 'Mən sadə istifadəçiyəm',

            'remember_token' => Str::random(10),

            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // ADMIN USER
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),

            'password' => Hash::make('11111111'),

            'phone_verified_at' => Carbon::now(),

            'current_role' => 'admin',

            'status' => 'active',

            'avatar' => null,
            'bio' => 'Sistem administratoru',

            'remember_token' => Str::random(10),

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
