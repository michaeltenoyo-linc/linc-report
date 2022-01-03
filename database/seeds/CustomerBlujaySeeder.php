<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\Customer;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerBlujaySeeder extends Seeder
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
        Customer::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/Database_Customers_012022.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                Customer::create([
                    'reference'=> $data['0'],
                    'name'=> $data['1'],
                    'status'=> $data['2'],
                    'address1'=> $data['3'],
                    'address2'=> $data['4'],
                    'address3'=> $data['5'],
                    'city'=> $data['6'],
                    'state'=> $data['7'],
                    'postal_code'=> $data['8'],
                    'country'=> $data['9'],
                    'timezone'=> $data['10'],
                    'parent_customer'=> $data['11'],
                    'default_freight_terms'=> $data['12'],
                    'freight_billable_party'=> $data['13'],
                    'supports_billable_rating'=> $data['14'],
                    'supports_manual_billable_rate'=> $data['15'],
                    'billable_methods'=> $data['16'],
                    'default_billable_method'=> $data['17'],
                    'default_trans_currency'=> $data['18'],
                    'bill_canadian_taxes'=> $data['19'],
                    'bill_value_added_taxes'=> $data['20'],
                    'support_billable_invoicing'=> $data['21'],
                    'required_pod'=> $data['22'],
                    'shipment_consolidation'=> $data['23'],
                    'geography_consolidation'=> $data['24'],
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
