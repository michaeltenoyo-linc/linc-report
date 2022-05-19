<?php

use App\Models\unit_surabaya;
use Illuminate\Database\Seeder;

class UnitSurabayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        unit_surabaya::truncate();

        $csvFile = fopen(base_path("reference/unit/UnitSurabayaList.csv"),"r");
        
        $firstline = true;

        while(($data = fgetcsv($csvFile, 2000, ';')) != FALSE){
            if (!$firstline){
                unit_surabaya::create([
                    'nopol' => $data['0'],
                    'type' => $data['1'],
                    'customer' => $data['2'],
                    'driver' => $data['3'],
                    'own' => $data['4'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
