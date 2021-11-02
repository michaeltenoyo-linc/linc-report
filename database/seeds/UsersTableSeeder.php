<?php

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
        $seeds= [
            [
                'name' => 'ming',
                'email' => 'michaeltenoyo.lincgroup@gmail.com',
                'password' => Hash::make('admin'),
            ],
            [
                'name' => 'kiky',
                'email' => 'kiky@gmail.com',
                'password' => Hash::make('admin'),
            ]
        ];

        DB::table('users')->insert($seeds);
    }
}
