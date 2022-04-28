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
use App\Models\SalesBudget;
use App\Models\Village;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SalesBudgetSeeder extends Seeder
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
        SalesBudget::truncate();

        //2022

        //WAREHOUSE
        $csvFile = fopen(base_path("reference/sales_report/BUDGET_WAREHOUSE_2022.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            error_log("Budget Warehouse : ".$counter,0);
            $counter++;
            if (!$firstline){
                //1
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','01'),
                    'budget' => $data['5']
                ]);

                //2
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','02'),
                    'budget' => $data['6']
                ]);

                //3
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','03'),
                    'budget' => $data['7']
                ]);

                //4
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','04'),
                    'budget' => $data['8']
                ]);

                //5
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','05'),
                    'budget' => $data['9']
                ]);

                //6
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','06'),
                    'budget' => $data['10']
                ]);

                //7
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','07'),
                    'budget' => $data['11']
                ]);

                //8
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','08'),
                    'budget' => $data['12']
                ]);

                //9
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','09'),
                    'budget' => $data['13']
                ]);

                //10
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','10'),
                    'budget' => $data['14']
                ]);

                //11
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','11'),
                    'budget' => $data['15']
                ]);

                //12
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','12'),
                    'budget' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);

        //BULK
        $csvFile = fopen(base_path("reference/sales_report/BUDGET_BULK_2022.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ',','"')) != FALSE){
            error_log("Budget Bulk : ".$counter,0);
            $counter++;
            if (!$firstline){
                //1
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','01'),
                    'budget' => $data['5']
                ]);

                //2
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','02'),
                    'budget' => $data['6']
                ]);

                //3
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','03'),
                    'budget' => $data['7']
                ]);

                //4
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','04'),
                    'budget' => $data['8']
                ]);

                //5
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','05'),
                    'budget' => $data['9']
                ]);

                //6
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','06'),
                    'budget' => $data['10']
                ]);

                //7
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','07'),
                    'budget' => $data['11']
                ]);

                //8
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','08'),
                    'budget' => $data['12']
                ]);

                //9
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','09'),
                    'budget' => $data['13']
                ]);

                //10
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','10'),
                    'budget' => $data['14']
                ]);

                //11
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','11'),
                    'budget' => $data['15']
                ]);

                //12
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','12'),
                    'budget' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);

        //TRANSPORT
        $csvFile = fopen(base_path("reference/sales_report/BUDGET_TRANSPORT_2022.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log("Budget Transport : ".$counter,0);
            $counter++;
            if (!$firstline){
                //1
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','01'),
                    'budget' => $data['5']
                ]);

                //2
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','02'),
                    'budget' => $data['6']
                ]);

                //3
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','03'),
                    'budget' => $data['7']
                ]);

                //4
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','04'),
                    'budget' => $data['8']
                ]);

                //5
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','05'),
                    'budget' => $data['9']
                ]);

                //6
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','06'),
                    'budget' => $data['10']
                ]);

                //7
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','07'),
                    'budget' => $data['11']
                ]);

                //8
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','08'),
                    'budget' => $data['12']
                ]);

                //9
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','09'),
                    'budget' => $data['13']
                ]);

                //10
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','10'),
                    'budget' => $data['14']
                ]);

                //11
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','11'),
                    'budget' => $data['15']
                ]);

                //12
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','12'),
                    'budget' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);

        //EXIM
        $csvFile = fopen(base_path("reference/sales_report/BUDGET_EXIM_2022.csv"),"r");

        $firstline = true;

        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log("Budget Exim : ".$counter,0);
            $counter++;
            if (!$firstline){
                //1
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','01'),
                    'budget' => $data['5']
                ]);

                //2
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','02'),
                    'budget' => $data['6']
                ]);

                //3
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','03'),
                    'budget' => $data['7']
                ]);

                //4
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','04'),
                    'budget' => $data['8']
                ]);

                //5
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','05'),
                    'budget' => $data['9']
                ]);

                //6
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','06'),
                    'budget' => $data['10']
                ]);

                //7
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','07'),
                    'budget' => $data['11']
                ]);

                //8
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','08'),
                    'budget' => $data['12']
                ]);

                //9
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','09'),
                    'budget' => $data['13']
                ]);

                //10
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','10'),
                    'budget' => $data['14']
                ]);

                //11
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','11'),
                    'budget' => $data['15']
                ]);

                //12
                SalesBudget::create([
                    'sales' =>$data['0'],
                    'division' =>$data['1'],
                    'customer_name' =>$data['2'],
                    'customer_sap' =>$data['3'],
                    'customer_status' =>$data['4'],
                    'period' => Carbon::create('2022','12'),
                    'budget' => $data['16']
                ]);
            }

            $firstline = false;
        }
        fclose($csvFile);
    }
}
