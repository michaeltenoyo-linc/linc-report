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

class LoaTransport_3_LTL extends Seeder
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
        // [3] Lautan Luas : 01/04/2022 - 31-03-2023
        Loa_transport::create([
            'customer' => "Lautan Luas (LTL)",
            'cross_customer_reference' => "8000000010",
            'periode_start' => Carbon::create('2020','05','01'),
            'periode_end' => Carbon::create('2023','06','09'),
            'files' => "3-1-LTL Trucking List.xls"
        ]);

        //ALL MARGOMULYO REGULER
        
        error_log("[3] LOA : Lautan Luas Margomulyo Reguler");
        $csvFile = fopen(base_path("reference/loa/transport/3-ltl-margomulyo-reguler.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                //L-300
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'L-300',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['4'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //CDE
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'CDE',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['5'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //CDD
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'CDD',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['6'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //Fuso Engkel
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'Fuso Engkel',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['7'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //Tronton
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'Tronton',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['8'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

        //ALL VETERAN REGULER
        
        error_log("[3] LOA : Lautan Luas Veteran Reguler");
        $csvFile = fopen(base_path("reference/loa/transport/3-ltl-veteran-reguler.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                //L-300
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'L-300',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['4'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //CDE
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'CDE',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['5'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //CDD
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'CDD',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['6'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //Fuso Engkel
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'Fuso Engkel',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['7'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);

                //Tronton
                dloa_transport::create([
                    'id_loa' => 3,
                    'unit' => 'Tronton',
                    'kapasitas' => $data['1'],
                    'rute_start_cross_relation' => 'district',
                    'rute_end_cross_relation' => 'district',
                    'rute_start' => $data['2'],
                    'rute_end' => $data['3'],
                    'rate' => $data['8'],
                    'multidrop' => 0,
                    'overnight' => 0,
                    'loading' => 0,
                    'otherName' => '',
                    'otherRate' => ''
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
