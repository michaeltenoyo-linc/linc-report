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
        /*
            Priviledges :
            master -> ALL
            smart -> SMART Customer
            ltl -> Lautan Luas
            loa -> Letter of Agreements
            gfs -> Greenfields
        */

        User::truncate();

        $seeds= [
            [
                'name' => 'Master',
                'email' => 'admin.master@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('adminmaster12345'),
                'active' => 1,
            ],
            [
                'name' => 'ming',
                'email' => 'michaeltenoyo.lincgroup@gmail.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'kiky',
                'email' => 'yulainda.kiki@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'ros',
                'email' => 'rosy.tasaniyah@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'Wanna',
                'email' => 'wannalisa@linc-express.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'LOA Admin',
                'email' => 'admin.loa@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('adminloa12345'),
                'active' => 1,
            ],
            [
                'name' => 'hendry',
                'email' => 'hendry@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'edwin',
                'email' => 'edwin@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'adit',
                'email' => 'adit@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'goto',
                'email' => 'goto@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
            [
                'name' => 'olive',
                'email' => 'olivia.regina@lincgrp.com',
                'email_verified_at' => Carbon::today(),
                'password' => Hash::make('admin'),
                'active' => 1,
            ],
        ];

        foreach ($seeds as $seed) {
            User::create($seed);
        }
    }
}
