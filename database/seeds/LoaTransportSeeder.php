<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Loa_transport;
use App\Models\dloa_transport;

class LoaTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dloa_transport::truncate();
        Loa_transport::truncate();

        //SMARTRUNGKUT110821
        Loa_transport::create([
            'customer' => "SMART RUNGKUT",
            'periode_start' => Carbon::create('2021','04','01'),
            'periode_end' => Carbon::create('2022','03','31'),
            'files' => "loa_transport_1.xlxs;"
        ]);

        //CDE
        $csvFile = fopen(base_path("reference/loa/transport/smart-rungkut-cde-1.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                dloa_transport::create([
                    'id_loa' => 1,
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

        //CDD
        $csvFile = fopen(base_path("reference/loa/transport/smart-rungkut-cdd-1.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                dloa_transport::create([
                    'id_loa' => 1,
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

        //FUSO
        $csvFile = fopen(base_path("reference/loa/transport/smart-rungkut-fuso-1.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                dloa_transport::create([
                    'id_loa' => 1,
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

        //Wingbox
        $csvFile = fopen(base_path("reference/loa/transport/smart-rungkut-wingbox-1.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            if (!$firstline){
                dloa_transport::create([
                    'id_loa' => 1,
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
