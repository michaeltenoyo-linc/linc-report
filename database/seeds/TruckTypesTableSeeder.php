<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Trucks;
use App\Models\TruckType;

class TruckTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TruckType::truncate();

        $csvFile = fopen(base_path("reference/BlujayTruckType_20221108.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ';')) != FALSE) {
            if (!$firstline) {
                TruckType::create([
                    'reference' => $data['0'],
                    'short' => $data['3'],
                    'type' => $data['5'],
                    'min_weight' => $data['6'] == '' ? 0 : $data['6'],
                    'max_weight' => $data['7'] == '' ? 0 : $data['7'],
                    'integration' => $data['1'],
                    'status' => $data['20']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
