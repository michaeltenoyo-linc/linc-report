<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Trucks;

class TrucksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trucks::truncate();

        $csvFile = fopen(base_path("reference/MASTER DATA TRUCK BP.csv"),"r");
        
        $firstline = true;

        while(($data = fgetcsv($csvFile, 2000, ';')) != FALSE){
            if (!$firstline){
                Trucks::create([
                    'nopol' => $data['1'],
                    'fungsional' => $data['2'],
                    'ownership' => $data['3'],
                    'owner' => $data['4'],
                    'type' => $data['5'],
                    'v_gps' => $data['6'],
                    'site' => $data['7'],
                    'area' => $data['8'],
                    'taken' => $data['13'],
                    'kategori' => $data['12']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
