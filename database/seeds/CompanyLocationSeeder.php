<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\Company;
use App\Models\District;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use App\Models\postal_code;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyLocationSeeder extends Seeder
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
        Company::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/Database_Routes_Company.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                $postalBPS = postal_code::where('postal_code',$data['8'])->first();
                $province = Province::where('name',$postalBPS->province)->first();
                $city = Regency::where('name',$postalBPS->city)->first();
                $district = District::where('name',$postalBPS->district)->first();
                $urban = Village::where('name',$postalBPS->urban)->first();
                Company::create([
                    'reference' => $data['0'],
                    'location' => $data['1'],
                    'address_1' => $data['2'],
                    'address_2' => $data['3'],
                    'address_3' => $data['4'],
                    'country' => $data['5'],
                    'urban' => $urban,
                    'district' => $district,
                    'city' => $city,
                    'province' => $province,
                    'postal_code' => $data['8'],
                    'timezone' => $data['9'],
                    'latitude' => $data['10'],
                    'longitude' => $data['11'],
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
