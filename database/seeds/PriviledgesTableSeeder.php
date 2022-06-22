<?php

use App\Models\Priviledge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PriviledgesTableSeeder extends Seeder
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
            sales -> Sales Area
        */

        Priviledge::truncate();

        $seeds= [
            [
                'user_id' => 1,
                'priviledge' => 'master',
            ],
            [
                'user_id' => 2,
                'priviledge' => 'master',
            ],
            [
                'user_id' => 3,
                'priviledge' => 'smart',
            ],
            [
                'user_id' => 4,
                'priviledge' => 'smart;ltl;gfs;loa',
            ],
            [
                'user_id' => 5,
                'priviledge' => 'smart;ltl;gfs;loa',
            ],
            [
                'user_id' => 6,
                'priviledge' => 'loa',
            ],
            [
                'user_id' => 7,
                'priviledge' => 'smart',
            ],
            [
                'user_id' => 8,
                'priviledge' => 'sales',
            ],
            [
                'user_id' => 9,
                'priviledge' => 'sales',
            ],
            [
                'user_id' => 10,
                'priviledge' => 'master',
            ],
        ];

        foreach ($seeds as $seed) {
            Priviledge::create($seed);
        }
    }
}
