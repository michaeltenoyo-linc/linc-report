<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\BillableBlujay;
use App\Models\BillableMethod;
use App\Models\Company;
use App\Models\Customer;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillableBlujaySeeder extends Seeder
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
        BillableBlujay::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/loa/kirim_exim_transport_blujay_05012022.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        $errorLog = [];
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                //Error Notes
                $passFrom = "ERR";
                $passDest = "ERR";
                $passBillable = "ERR";
                $passCust = "ERR";


                try {
                    $fromCompanies = Company::where('reference',$data['9'])->first();
                    $passFrom = $fromCompanies->reference;
                    $destCompanies = Company::where('reference',$data['10'])->first();
                    $passDest = $destCompanies->reference;
                    $billable_method = BillableMethod::where('billable_method',$data['0'])->first();
                    $passBillable = $billable_method->billable_method;
                    $customer = Customer::where('billable_methods','LIKE','%'.$billable_method->cross_reference.'%')->first();
                    $passCust = $customer->reference;

                    BillableBlujay::create([
                        'billable_tariff'=> $data['0'],
                        'billable_subtariff'=> $data['1'],
                        'customer_reference'=> $customer->reference,
                        'division'=> $data['2'],
                        'order_group'=> $data['3'],
                        'equipment'=> $data['4'],
                        'allocation_method'=> $data['5'],
                        'tier'=> $data['6'],
                        'all_inclusive'=> $data['7'],
                        'precedence'=> $data['8'],
                        'origin_location'=> $data['9'],
                        'destination_location'=> $data['10'],
                        'origin_city' => $fromCompanies->city,
                        'destination_city' => $destCompanies->city,
                        'origin_province' => $fromCompanies->province,
                        'destination_province' => $destCompanies->province,
                        'no_intermediate_stop'=> $data['11'],
                        'basis'=> $data['12'],
                        'sku'=> $data['13'],
                        'rate'=> round(floatval($data['14']),2),
                        'currency'=> $data['15'],
                        'effective_date'=> Carbon::createFromFormat('d/m/Y', $data['16']),
                        'expiration_date'=> Carbon::createFromFormat('d/m/Y', $data['17']),
                    ]);
                } catch (\Throwable $th) {
                    array_push($errorLog,[$counter, $data['0'], $data['1'], $data['2'], $data['9'], $data['10'], $passFrom, $passDest, $passBillable, $passCust]);
                    print("ERROR BILLABLE");
                }
                
            }

            $firstline = false;
        }

        fclose($csvFile);

        //write ERRORLOG
        $fp = fopen('billable_error.csv', 'w');
        foreach ($errorLog as $fields) {
            
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }
}
