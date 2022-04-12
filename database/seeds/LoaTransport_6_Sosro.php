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

class LoaTransport_6_Sosro extends Seeder
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
            'customer' => "PT. SINAR SOSRO",
            'cross_customer_reference' => "3000005216",
            'periode_start' => Carbon::create('2019','12','01'),
            'periode_end' => Carbon::create('2029','12','31'),
            'files' => "6-1-Quotation SOSRO 2021.pdf;6-2-SOSRO Wilayah.xlsx;6-3-SOSRO Pati Jateng.png;6-4-SOSRO Banyuwangi.pdf;"
        ]);

        //ALL MARGOMULYO REGULER
        
        error_log("[6] Sosro");

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
