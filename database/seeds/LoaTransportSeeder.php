<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Loa_transport;
use App\Models\dloa_transport;

class LoaTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dloa_transport::truncate();
        Loa_transport::truncate();

        //[1] SMART RUNGKUT
        $this->call(LoaTransport_1_SmartRungkut::class);

        //[2] SMART MT 17122021
        $this->call(LoaTransport_2_SmartMT::class);
    }
}
