<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\Company;
use App\Models\dloa_transport;
use App\Models\postal_code;
use App\Models\Loa_transport;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostalCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     *
     * @return void
     */
    public function run()
    {
        postal_code::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/kodepos_BPS.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                postal_code::create([
                    'province' => $data['0'],
                    'city' => $data['1'],
                    'district' => $data['2'],
                    'urban' => $data['3'],
                    'postal_code' => $data['4'],
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
