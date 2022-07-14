<?php

namespace App\Http\Controllers\ThirdParty;

use App\Models\LoadPerformance;
use Google\Service\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Yajra\DataTables\Facades\DataTables;


class BlujayController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function storeData($raw, $type){
        $path = "";
        switch ($type) {
            case 'shipment':
                $path = "../reference/local_blujay/RefreshShipmentBlujay.csv";
                break;
            case 'performance':
                $path = "../reference/local_blujay/LoadPerformanceBlujay.csv";
                break;
            case 'addcost':
                $path = "../reference/local_blujay/RefreshAddcost.csv";
                break;
        }
        
        $data = strtr($raw, array('-' => '+', '_' => '/'));

        $myfile = fopen($path, "w+");
        fwrite($myfile, base64_decode($data));
        fclose($myfile);
    }

    public function injectSql(Request $req){
        $req->validate([
            'shipment' => 'required',
            'performance' => 'required',
            'addcost' => 'required'
        ]);

        $this->storeData($req->input('shipment'), 'shipment');
        $this->storeData($req->input('performance'), 'performance');
        $this->storeData($req->input('addcost'), 'addcost');

        return response()->json(['message' => "Berhasil inject database"], 200);
    }
}