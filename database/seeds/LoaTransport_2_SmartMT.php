<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\dloa_transport;
use App\Models\Loa_transport;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoaTransport_2_SmartMT extends Seeder
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
        // [2] SMART MT : 01/04/2021 - 31-03-2022
        Loa_transport::create([
            'customer' => "SMART MT",
            'periode_start' => Carbon::create('2021','04','01'),
            'periode_end' => Carbon::create('2022','03','31'),
            'files' => "loa_transport_2.xlxs;"
        ]);

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/loa/transport/smart-mt-2.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                dloa_transport::create([
                    'id_loa' => 2,
                    'unit' => $data['1'],
                    'kapasitas' => $data['2'],
                    'rute_start' => $data['3'],
                    'rute_end' => $data['4'],
                    'rate' => $data['5'],
                    'multidrop' => $data['6'],
                    'overnight' => $data['7'],
                    'loading' => $data['8'],
                    'otherName' => $data['9'],
                    'otherRate' => $data['10']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
