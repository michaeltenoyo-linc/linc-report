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
        $csvFile = fopen(base_path("reference/Database_Customers_102022.csv"), "r");

        $firstline = true;

        $counter = 1;
        while (($data = fgetcsv($csvFile, 0, ';', '"')) != FALSE) {
            error_log($counter, 0);
            $counter++;
            if (!$firstline) {
                Customer::create([
                    'reference' => $data['0'],
                    'name' => $data['1'],
                    'status' => $data['2'],
                ]);
            }

            $firstline = false;
        }

        fclose($csvFile);
    }
}
