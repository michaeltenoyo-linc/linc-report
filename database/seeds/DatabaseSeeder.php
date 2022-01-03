<?php

use App\Models\Priviledge;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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
            ItemsTableSeeder::class,
            TrucksTableSeeder::class,
            UsersTableSeeder::class,
            PriviledgesTableSeeder::class,
            //CompanyLocationSeeder::class, => Seed Manual
            //LoaTransportSeeder::class, => Seed Manual
            //IndoRegionSeeder::class, => Seed Manual
            //LoadPerformanceSeeder::class, => Seed Manual
            //CustomerBlujaySeeder::class, => Seed Manual
        ]);
    }
}
