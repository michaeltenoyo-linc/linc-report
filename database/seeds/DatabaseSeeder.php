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

            /*SEED MANUAL

                !!Seed if needed only!!
                LoaTransportSeeder::class, => Seeding format ulang loa transport yang berlaku
                IndoRegionSeeder::class, => inject area" di indonesia pada db

                !!BLUJAY!!
                CompanyLocationSeeder::class, => inject lokasi - lokasi stop area dari customer                
                CustomerBlujaySeeder::class, => inject data customer blujay
                BillableBlujaySeeder::class, => inject data biaya kirim dari loa pada blujay
            
                !!Seed daily/weekly!!
                LoadPerformanceSeeder::class, => Data load id
            */
        ]);
    }
}
