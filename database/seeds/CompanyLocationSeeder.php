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
use App\Models\FixCompany;
use App\Models\Loa_transport;
use App\Models\postal_code;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $errorLog = [];
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                try {
                    $postalBPS = postal_code::where('postal_code',strval($data['8']))->first();

                    if(is_null($postalBPS)){
                        $province = "UNDEFINED";
                        $city = "UNDEFINED";
                        $district = "UNDEFINED";
                        $urban = "UNDEFINED";
                        $postal = "UNDEFINED";
                    }else{
                        $province = $postalBPS->province;
                        $city = $postalBPS->city;
                        $district = $postalBPS->district;
                        $urban = $postalBPS->urban;
                        $postal = $postalBPS->postal_code;
                    }

                    
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
                        'postal_code' => $postal,
                        'timezone' => $data['9'],
                        'latitude' => $data['10'],
                        'longitude' => $data['11'],
                        'blujay_city' => $data['6'],
                    ]);
                } catch (\Throwable $th) {
                    array_push($errorLog,[$counter, $data['0'], $data['1'], $data['2'], $data['3'], $data['4'], $data['10'], $data['11'], $data['8']]);
                    print("ERROR POSTCODE");
                }
            }

            $firstline = false;
        }
        fclose($csvFile);

        //write ERRORLOG
        $fp = fopen('postal_error.csv', 'w');
        foreach ($errorLog as $fields) {

            fputcsv($fp, $fields);
        }
        fclose($fp);
    }
}
