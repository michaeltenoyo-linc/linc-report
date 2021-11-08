<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $seeds= [
            [
                'name' => 'ming',
                'email' => 'michaeltenoyo.lincgroup@gmail.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'kiky',
                'email' => 'kiky@gmail.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'ros',
                'email' => 'ros@gmail.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ]
        ];

        DB::table('users')->insert($seeds);
    }
}