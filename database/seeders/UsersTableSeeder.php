<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Test User 3',
                'email' => 'test3@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
