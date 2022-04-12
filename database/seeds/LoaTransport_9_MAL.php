<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use App\Models\dloa_transport;
use App\Models\Loa_transport;
use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoaTransport_9_MAL extends Seeder
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
        // [3] Lautan Luas : 01/06/2020 - 31-12-2029
        Loa_transport::create([
            'customer' => "MULTI ANUGERAH LESTARI TEXINDO",
            'cross_customer_reference' => "3000003865",
            'periode_start' => Carbon::create('2020','06','24'),
            'periode_end' => Carbon::create('2028','06','15'),
            'files' => "9-1-Quotation Trucking 2021.pdf;9-2-Quotation Trucking 2020.png;9-3-Biaya Kuli.png;9-4-Trucking Exim.pdf"
        ]);

        //ALL MARGOMULYO REGULER
        
        error_log("[9] MAL");

        //DLOA Excel -- Use this to add specific routes information
        /*
        $csvFile = fopen(base_path("reference/loa/transport/3-ltl-margomulyo-reguler.csv"),"r");
        
        $firstline = true;
        
        while(($data = fgetcsv($csvFile, 5000, ';','"')) != FALSE){
            
        }

        fclose($csvFile);
        */
    }
}
