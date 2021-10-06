<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TrucksTableSeeder extends Seeder
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
                'nopol' => "B9058SXS",
                'fungsional' => "logistik",
                'ownership' => "own",
                'owner' => "own",
                'type' => "cdd chiller",
                'v_gps' => "oslog",
                'site' => "NL Surabaya",
                'area' => "surabaya",
                'taken' => 1,
                'kategori'=> 5000,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'nopol' => "B9059SXS",
                'fungsional' => "logistik",
                'ownership' => "own",
                'owner' => "own",
                'type' => "cdd chiller",
                'v_gps' => "oslog",
                'site' => "NL Surabaya",
                'area' => "surabaya",
                'taken' => 1,
                'kategori'=> 3000,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'nopol' => "B9060SXS",
                'fungsional' => "logistik",
                'ownership' => "own",
                'owner' => "own",
                'type' => "cdd chiller",
                'v_gps' => "oslog",
                'site' => "NL Surabaya",
                'area' => "surabaya",
                'taken' => 1,
                'kategori'=> 3000,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('trucks')->insert($seeds);
    }
}
