<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds= [
            [
                'material_code' => "801524",
                'description' => "Filma CO 6x2L Pch",
                'gross_weight' => 11.54,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801522",
                'description' => "Filma CO 6x5L Jrc",
                'gross_weight' => 18.07,
                'nett_weight' => 18.1,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801521",
                'description' => "Filma CO SNI 12x1L BTL",
                'gross_weight' => 11.49,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801523",
                'description' => "Filma CO SNI 6x2L Btl",
                'gross_weight' => 10.84,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801175",
                'description' => "Filma Cooking Oil (0716) 12x1L Pch",
                'gross_weight' => 11.54,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801174",
                'description' => "Filma Cooking Oil (0716) 6x2L Pch",
                'gross_weight' => 11.54,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801184",
                'description' => "Filma Cooking Oil (0816) 12x1L Pch",
                'gross_weight' => 11.64,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801185",
                'description' => "Filma Cooking Oil (0816) 6x2L Pch",
                'gross_weight' => 11.71,
                'nett_weight' => 10.86,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'material_code' => "801204",
                'description' => "Filma Cooking Oil (0916) 4x5L Jrc",
                'gross_weight' => 19.42,
                'nett_weight' => 18.1,
                'category' => "Branded",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];
        
        DB::table('items')->insert($seeds);
    }
}
