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
        */

        Priviledge::truncate();

        $seeds= [
            [
                'user_id' => 1,
                'priviledge' => 'master',
            ],
            [
                'user_id' => 2,
                'priviledge' => 'smart',
            ],
            [
                'user_id' => 3,
                'priviledge' => 'smart;ltl;gfs',
            ],
        ];

        DB::table('priviledges')->insert($seeds);
    }
}
