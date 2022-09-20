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
use App\Models\SalesForecast;
use App\Models\Village;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SalesForecastSeeder2023 extends Seeder
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
        //2023

        //WAREHOUSE
        $csvFile = fopen(base_path("reference/sales_report/FORECAST_WAREHOUSE_2023.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log("Forecast Warehouse : ".$counter,0);
            $counter++;
            if (!$firstline){
                //Data Validation
                if($data['3'] == ''){
                    $data['3'] = '0';
                }
                
                for ($i=5; $i <= 16; $i++) { 
                    if($data[$i] == ''){
                        $data[$i] = '0';
                    }
                }

                //1
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','01'),
                    'forecast' => $data['5']
                ]);

                //2
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','02'),
                    'forecast' => $data['6']
                ]);

                //3
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','03'),
                    'forecast' => $data['7']
                ]);

                //4
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','04'),
                    'forecast' => $data['8']
                ]);

                //5
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','05'),
                    'forecast' => $data['9']
                ]);

                //6
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','06'),
                    'forecast' => $data['10']
                ]);

                //7
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','07'),
                    'forecast' => $data['11']
                ]);

                //8
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','08'),
                    'forecast' => $data['12']
                ]);

                //9
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','09'),
                    'forecast' => $data['13']
                ]);

                //10
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','10'),
                    'forecast' => $data['14']
                ]);

                //11
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','11'),
                    'forecast' => $data['15']
                ]);

                //12
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','12'),
                    'forecast' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);

        //BULK
        $csvFile = fopen(base_path("reference/sales_report/FORECAST_BULK_2023.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log("forecast Bulk : ".$counter,0);
            $counter++;
            if (!$firstline){
                //Data Validation
                if($data['3'] == ''){
                    $data['3'] = '0';
                }
                
                for ($i=5; $i <= 16; $i++) { 
                    if($data[$i] == ''){
                        $data[$i] = '0';
                    }
                }

                //1
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','01'),
                    'forecast' => $data['5']
                ]);

                //2
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','02'),
                    'forecast' => $data['6']
                ]);

                //3
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','03'),
                    'forecast' => $data['7']
                ]);

                //4
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','04'),
                    'forecast' => $data['8']
                ]);

                //5
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','05'),
                    'forecast' => $data['9']
                ]);

                //6
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','06'),
                    'forecast' => $data['10']
                ]);

                //7
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','07'),
                    'forecast' => $data['11']
                ]);

                //8
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','08'),
                    'forecast' => $data['12']
                ]);

                //9
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','09'),
                    'forecast' => $data['13']
                ]);

                //10
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','10'),
                    'forecast' => $data['14']
                ]);

                //11
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','11'),
                    'forecast' => $data['15']
                ]);

                //12
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','12'),
                    'forecast' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);

        //TRANSPORT
        $csvFile = fopen(base_path("reference/sales_report/FORECAST_TRANSPORT_2023.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log("forecast Transport : ".$counter,0);
            $counter++;
            if (!$firstline){
                //Data Validation
                if($data['3'] == ''){
                    $data['3'] = '0';
                }
                
                for ($i=5; $i <= 16; $i++) { 
                    if($data[$i] == ''){
                        $data[$i] = '0';
                    }
                }

                //1
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','01'),
                    'forecast' => $data['5']
                ]);

                //2
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','02'),
                    'forecast' => $data['6']
                ]);

                //3
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','03'),
                    'forecast' => $data['7']
                ]);

                //4
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','04'),
                    'forecast' => $data['8']
                ]);

                //5
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','05'),
                    'forecast' => $data['9']
                ]);

                //6
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','06'),
                    'forecast' => $data['10']
                ]);

                //7
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','07'),
                    'forecast' => $data['11']
                ]);

                //8
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','08'),
                    'forecast' => $data['12']
                ]);

                //9
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','09'),
                    'forecast' => $data['13']
                ]);

                //10
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','10'),
                    'forecast' => $data['14']
                ]);

                //11
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','11'),
                    'forecast' => $data['15']
                ]);

                //12
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','12'),
                    'forecast' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);

        //EXIM
        $csvFile = fopen(base_path("reference/sales_report/FORECAST_EXIM_2023.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log("forecast Exim : ".$counter,0);
            $counter++;
            if (!$firstline){
                //Data Validation
                if($data['3'] == ''){
                    $data['3'] = '0';
                }
                
                for ($i=5; $i <= 16; $i++) { 
                    if($data[$i] == ''){
                        $data[$i] = '0';
                    }
                }
                
                //1
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','01'),
                    'forecast' => $data['5']
                ]);

                //2
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','02'),
                    'forecast' => $data['6']
                ]);

                //3
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','03'),
                    'forecast' => $data['7']
                ]);

                //4
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','04'),
                    'forecast' => $data['8']
                ]);

                //5
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','05'),
                    'forecast' => $data['9']
                ]);

                //6
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','06'),
                    'forecast' => $data['10']
                ]);

                //7
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','07'),
                    'forecast' => $data['11']
                ]);

                //8
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','08'),
                    'forecast' => $data['12']
                ]);

                //9
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','09'),
                    'forecast' => $data['13']
                ]);

                //10
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','10'),
                    'forecast' => $data['14']
                ]);

                //11
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','11'),
                    'forecast' => $data['15']
                ]);

                //12
                SalesForecast::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2023','12'),
                    'forecast' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);
    }
}
