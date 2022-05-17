<?php

use App\Models\lead_time;
use Illuminate\Database\Seeder;

class LeadTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        lead_time::truncate();

        $csvFile = fopen(base_path("reference/RGSurabayaList.csv"),"r");
        $counter = 1;
        $firstline = true;
        $errorLog = [];
        while(($data = fgetcsv($csvFile, 2000, ';')) != FALSE){
            error_log("Seeding Lead Times : ".$counter);
            if (!$firstline){
                try {
                    lead_time::create([
                        'rg' => $data['0'],
                        'cluster' => $data['1'],
                        'ltpod' => $data['2']==''?0:$data['2'],
                    ]);
                } catch (\Throwable $th) {
                    $existingData = lead_time::where('rg',$data['0'])->first();
                    if($existingData->ltpod != $data['2']){
                        array_push($errorLog,[$existingData->rg, $existingData->ltpod, $data['0'], $data['1'], $data['2']]);
                    }
                }
            }
            $counter++;
            $firstline = false;
        }

        fclose($csvFile);

        //write ERRORLOG
        $fp = fopen('errorlog/leadtime_seeding_error.csv', 'w');
        foreach ($errorLog as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }
}
