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
use App\Models\Addcost;
use App\Models\postal_code;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AddcostRateSeeder extends Seeder
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
        //Addcost::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/local_blujay/RefreshAddcost.csv"),"r");

        $firstline = true;
        $checkedLoads = [];

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            error_log("Addcost : ".$counter,0);
            $counter++;
            if (!$firstline){
                //Check Duplicate Data
                $isChecked = false;
                
                foreach ($checkedLoads as $ch) {
                    if($data['0'] == $ch){
                        $isChecked = true;
                    }
                }

                if(!$isChecked){
                    $existCheck = Addcost::where('load_id','=',$data['0'])->get();

                    if(!is_null($existCheck)){
                        foreach ($existCheck as $df) {
                            $df->forceDelete();
                        }
                    }

                    array_push($checkedLoads, $data['0']);
                }
                //END CHECK DUPLICATE DATA

                Addcost::create([
                    'load_id' =>$data['0'],
                    'rate' => round(floatval(str_replace(',','',$data['2'])),2),
                    'type' => $data['7'],
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);
    }
}
