<?php

use App\Models\dloa_transport;
use App\Models\Loa_transport;
use App\Models\Priviledge;
use Illuminate\Database\Seeder;

class LoaTransport_0_RefreshAll extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Loa_transport::truncate();
        dloa_transport::truncate();
        $this->call([
            LoaTransport_1_SmartRungkut::class,
            LoaTransport_2_SmartMT::class,
            LoaTransport_3_LTL::class,
        ]);
    }
}
