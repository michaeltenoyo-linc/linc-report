<?php

use App\Models\Priviledge;
use Illuminate\Database\Seeder;

class DailyBlujaySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            LoadPerformanceRefresh::class, //Data load id
            AddcostRateSeeder::class, //Data addcost blujay
            ShipmentBlujaySeeder::class, //Data individual SO blujay
        ]);
    }
}
