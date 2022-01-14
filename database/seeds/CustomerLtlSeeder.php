<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\CustomerLtl;

class CustomerLtlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerLtl::truncate();

        $csvFile = fopen(base_path("reference/customer_ltl.csv"),"r");
        
        $firstline = true;

        while(($data = fgetcsv($csvFile, 2000, ';')) != FALSE){
            if (!$firstline){
                CustomerLtl::create([
                    'name' => $data['1'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
