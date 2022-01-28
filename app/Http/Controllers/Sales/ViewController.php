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
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNan;
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
            ->addColumn('achievement_1m', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;

                
                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->where('load_group','SURABAYA LOG PACK')
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date('m'))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->where('load_group','SURABAYA EXIM TRUCKING')
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date('m'))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }

                if($row->budget > 0){
                    $percentage = floatval($actual)/floatval($row->budget) * 100;
                    $percentage = round(floatval($percentage), 2);
                }

                $divCol = "";

                if($percentage > 90){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-green-700 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 75){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-green-500 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 50){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-yellow-300 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 25){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-orange-400 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 10){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-orange-600 font-bold'> (".$percentage." %) </span>";
                }else{
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($row->budget,0,',','.')."</span> <span class='text-red-600 font-bold'> (".$percentage." %) </span>";
                }
                
                return $divCol;
            })
            ->addColumn('achievement_ytd', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;

                $currentMonth = intval('02');
                $ytd_month = [];

                for ($i=1; $i <= $currentMonth; $i++) { 
                    array_push($ytd_month,$i);
                    error_log($i);
                }

                $ytd_budget = SalesBudget::selectRaw('customer_name, SUM(budget) as budget')
                                        ->where('customer_name','=',$row->customer_name)
                                        ->where('division',$row->division)
                                        ->whereIn(DB::raw('month(period)'),$ytd_month)
                                        ->whereYear('period',date('Y'))
                                        ->groupBy('customer_name')
                                        ->first();


                
                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT

                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->where('load_group','SURABAYA LOG PACK')
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(load_closed_date)'),$ytd_month)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->where('load_group','SURABAYA EXIM TRUCKING')
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(load_closed_date)'),$ytd_month)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }

                if($row->budget > 0){
                    $percentage = floatval($actual)/floatval($ytd_budget->budget) * 100;
                    $percentage = round(floatval($percentage), 2);
                }

                $divCol = "";

                if($percentage > 90){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($ytd_budget->budget,0,',','.')."</span> <span class='text-green-700 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 75){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($ytd_budget->budget,0,',','.')."</span> <span class='text-green-500 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 50){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($ytd_budget->budget,0,',','.')."</span> <span class='text-yellow-300 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 25){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($ytd_budget->budget,0,',','.')."</span> <span class='text-orange-400 font-bold'> (".$percentage." %) </span>";
                }else if($percentage > 10){
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($ytd_budget->budget,0,',','.')."</span> <span class='text-orange-600 font-bold'> (".$percentage." %) </span>";
                }else{
                    $divCol = "Rp. ".number_format($actual,0,',','.')." / <span class='font-bold'>".number_format($ytd_budget->budget,0,',','.')."</span> <span class='text-red-600 font-bold'> (".$percentage." %) </span>";
                }
                
                return $divCol;
            })
            ->addColumn('period_mon', function($row){
                return date('M-Y',strtotime($row->period));
            })
            ->addColumn('graph', function($row){
                return "<canvas id='".$row->id."' value='".$row->id."' class='table-container-graph' width='100%' height='100px'><input type='hidden' name='budgetId' value='".$row->id."'></canvas>";
            })
            ->rawColumns(['achievement_1m','achievement_ytd','period_mon','graph'])
            ->make(true);
    }
}
