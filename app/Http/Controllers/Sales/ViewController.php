<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\Item;
use App\Models\SalesBudget;
use App\Models\ShipmentBlujay;
use App\Models\Suratjalan_greenfields;
use App\Models\Trucks;

use function PHPUnit\Framework\isNull;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('sales.pages.landing');
    }

    public function gotoMonitoringMaster(){
        return view('sales.pages.monitoring-master');
    }

    public function getBudgetActual(){
        $data = SalesBudget::whereMonth('period',date('m'))->whereYear('period',date('Y'))->get();

        return DataTables::of($data)
            ->addColumn('completation', function($row){
                //actual data
                $actual = 0;

                //BLUJAY DIVISION TRANSPORT
                if($row->division == "Pack Trans"){
                    $total = ShipmentBlujay::select('customer_name')->selectRaw('SUM(billable_total_rate) as totalActual')->groupBy('customer_name')->where('customer_name','=',$row->customer_name)->whereMonth('created_at','01')->first();
                    
                    if(!isNull($total)){
                        $actual = $total->totalActual;
                    }
                }

                $divCol = "Rp. ".$actual." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-red-600'> (0 %) </span>";

                return $divCol;
            })
            ->addColumn('period_mon', function($row){
                return date('M-Y',strtotime($row->period));
            })
            ->rawColumns(['completation','period_mon'])
            ->make(true);

    }
}
