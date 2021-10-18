<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::truncate();

        $csvFile = fopen(base_path("reference/Master ITEM v2.csv"),"r");
        
        $firstline = true;

        while(($data = fgetcsv($csvFile, 2000, ';')) != FALSE){
            if (!$firstline){
                Item::create([
                    'material_code' => $data['0'],
                    'description' => $data['1'],
                    'gross_weight' => $data['2'],
                    'nett_weight' => $data['2'],
                    'category' => $data['3'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
