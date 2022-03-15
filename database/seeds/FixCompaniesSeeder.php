<?php

use App\Models\FixCompany;
use Illuminate\Database\Seeder;

class FixCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FixCompany::truncate();

        $csvFile = fopen(base_path("reference/fix/company_fix/postal_error_fixed.csv"),"r");
        $firstline = true;

        $counter = 1;
        $errorLog = [];
        while(($data = fgetcsv($csvFile, 0, ';','"')) != FALSE){
            error_log($counter);
            $counter++;
            FixCompany::create([
                'reference' => $data['1'],
                'revision' => $data['9']
            ]);
        }

        fclose($csvFile);
    }
}
