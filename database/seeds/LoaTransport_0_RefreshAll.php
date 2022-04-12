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
            LoaTransport_4_GFS::class,
            LoaTransport_5_GCM::class,
            LoaTransport_6_Sosro::class,
            LoaTransport_7_WaruGunung::class,
            LoaTransport_8_Ecco::class,
            LoaTransport_9_MAL::class,
            LoaTransport_10_LTG::class,
        ]);
    }
}
