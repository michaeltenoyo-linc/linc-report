<?php

use App\Models\BillableMethod;
use Illuminate\Database\Seeder;

class BillableMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillableMethod::truncate();

        //FUSO dan WB
        $csvFile = fopen(base_path("reference/Billable_Methods_Reference.csv"),"r");
        
        $firstline = true;
        
        $counter = 1;
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log($counter,0);
            $counter++;
            if (!$firstline){
                BillableMethod::create([
                    'billable_method'=> $data['0'],
                    'cross_reference'=> $data['1'],
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
