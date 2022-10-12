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
        //Item::truncate();

        $csvFile = fopen(base_path("reference/smart/ItemSmart_202210.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ';')) != FALSE) {
            if (!$firstline) {
                $checkItem = Item::find($data['0']);

                if ($checkItem == null) {
                    error_log($data['0']);
                    Item::create([
                        'material_code' => $data['0'],
                        'description' => $data['1'],
                        'gross_weight' => 1,
                        'nett_weight' => 1,
                        'category' => 'BRANDED CONSUMER',
                    ]);
                } else {
                    $checkItem->update([
                        'description' => $data['1'],
                        'gross_weight' => 1,
                        'nett_weight' => 1,
                        'category' => 'BRANDED CONSUMER',
                    ]);

                    error_log($data['0'] . " Already Exist. UPDATING");
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
