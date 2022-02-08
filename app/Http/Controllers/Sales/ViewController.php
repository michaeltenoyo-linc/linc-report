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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNan;
use function PHPUnit\Framework\isNull;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //Blujay Load Group (Exim, Bulk, Transport)
    private $transportLoadGroups = ['SURABAYA LOG PACK', 'SURABAYA RENTAL', 'SURABAYA RENTAL TRIP', 'SURABAYA TIV LOKAL'];
    private $eximLoadGroups = ['SURABAYA EXIM TRUCKING', 'SURABAYA TIV IMPORT'];
    private $bulkLoadGroups = ['SURABAYA LOG BULK'];
    private $emptyLoadGroups = ['MOB KOSONGAN'];

    //Navigation
    public function gotoLandingPage(){
        return view('sales.pages.landing');
    }

    public function gotoMonitoringMaster(){
        return view('sales.pages.monitoring-master');
    }

    public function gotoBySales($sales){
        $data['sales'] = $sales;
        $data['sales_list'] = ['adit','edwin','willem'];

        for ($i=0; $i < count($data['sales_list']); $i++) {
            if($data['sales_list'][$i] == $sales){
                unset($data['sales_list'][$i]);
            }
        }

        return view('sales.pages.by-sales', $data);
    }

    public function gotoByDivision($division){
        $data['division'] = $division;
        $data['division_list'] = ['transport','bulk','warehouse','exim','kosongan'];

        for ($i=0; $i < count($data['division_list']); $i++) {
            if($data['division_list'][$i] == $division){
                unset($data['division_list'][$i]);
            }
        }

        return view('sales.pages.by-division', $data);
    }

    public function getMonthlyAchievement(Request $req){
        $month = '01';

        //GETTING DATA BY PROGRAM
        //transport
        $fetchTransport = ShipmentBlujay::selectRaw('DATE(load_closed_date) as days, SUM(billable_total_rate) as totalActual')
                                    ->whereIn('load_group',$this->transportLoadGroups)
                                    ->whereMonth('load_closed_date',$month)
                                    ->whereYear('load_closed_date',date('Y'))
                                    ->groupBy('days')
                                    ->get();

        $data['labelTransport'] = [];
        $data['dataTransport'] = [];

        foreach ($fetchTransport as $f) {
            array_push($data['dataTransport'], $f->totalActual);
            array_push($data['labelTransport'], $f->days);
        }

        //exim
        $fetchExim = ShipmentBlujay::selectRaw('DATE(load_closed_date) as days, SUM(billable_total_rate) as totalActual')
                                    ->whereIn('load_group',$this->eximLoadGroups)
                                    ->whereMonth('load_closed_date',$month)
                                    ->whereYear('load_closed_date',date('Y'))
                                    ->groupBy('days')
                                    ->get();


        $data['labelExim'] = [];
        $data['dataExim'] = [];

        foreach ($fetchExim as $f) {
            array_push($data['dataExim'], $f->totalActual);
            array_push($data['labelExim'], $f->days);
        }

        //bulk
        $fetchBulk = ShipmentBlujay::selectRaw('DATE(load_closed_date) as days, SUM(billable_total_rate) as totalActual')
                                    ->whereIn('load_group',$this->bulkLoadGroups)
                                    ->whereMonth('load_closed_date',$month)
                                    ->whereYear('load_closed_date',date('Y'))
                                    ->groupBy('days')
                                    ->get();


        $data['labelBulk'] = [];
        $data['dataBulk'] = [];

        foreach ($fetchExim as $f) {
            array_push($data['dataBulk'], $f->totalActual);
            array_push($data['labelBulk'], $f->days);
        }

        return response()->json($data, 200);
    }

    public function getYearlyRevenue (Request $req){
        $year = date('Y');
        $data['warehouse'] = [10000000,20000000,30000000,40000000,50000000,60000000,80000000,70000000,100000000,120000000,110000000,90000000];
        $data['transport'] = [];
        $data['exim'] = [];
        $data['bulk'] = [];

        for ($i=1; $i <= 12; $i++) {
            //Blujay Transport
            $fetchTransport = ShipmentBlujay::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',$i)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->first();

            if(!is_null($fetchTransport->totalActual)){
                array_push($data['transport'],$fetchTransport->totalActual);
            }else{
                array_push($data['transport'],0);
            }


            //Blujay Exim
            $fetchExim = ShipmentBlujay::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',$i)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->first();

            if(!is_null($fetchExim->totalActual)){
                array_push($data['exim'],$fetchExim->totalActual);
            }else{
                array_push($data['exim'],0);
            }

            //Blujay Bulk
            $fetchBulk = ShipmentBlujay::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',$i)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->first();

            if(!is_null($fetchBulk->totalActual)){
                array_push($data['bulk'],$fetchBulk->totalActual);
            }else{
                array_push($data['bulk'],0);
            }
        }

        return response()->json($data,200);
    }

    public function getYearlyAchievement(Request $req, $id){
        $tempBudget = SalesBudget::find($id);

        $data['message'] = "Sukses mengambil data budget.";
        $data['yearly_budget'] = SalesBudget::where('customer_name',$tempBudget->customer_name)
                                        ->where('division',$tempBudget->division)
                                        ->whereYear('period',date('Y'))
                                        ->orderBy('period','asc')
                                        ->get()
                                        ->pluck('budget');

        $data['yearly_revenue'] = [];

        //Blujay
        if($tempBudget->division == "Pack Trans"){
            for ($i=1; $i <= 12 ; $i++) {
                $monthlyRevenue = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$tempBudget->customer_sap)
                                        ->whereIn('load_group',$this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date($i))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                if(!is_null($monthlyRevenue)){
                    array_push($data['yearly_revenue'],$monthlyRevenue->totalActual);
                }else{
                    array_push($data['yearly_revenue'],0);
                }
            }
        }else if($tempBudget->division == "Freight Forwarding BP"){
            for ($i=1; $i <= 12 ; $i++) {
                $monthlyRevenue = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$tempBudget->customer_sap)
                                        ->whereIn('load_group', $this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date($i))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                if(!is_null($monthlyRevenue)){
                    array_push($data['yearly_revenue'],$monthlyRevenue->totalActual);
                }else{
                    array_push($data['yearly_revenue'],0);
                }
            }
        }else if($tempBudget->division == "Bulk Trans"){
            for ($i=1; $i <= 12 ; $i++) {
                $monthlyRevenue = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$tempBudget->customer_sap)
                                        ->whereIn('load_group', $this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date($i))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                if(!is_null($monthlyRevenue)){
                    array_push($data['yearly_revenue'],$monthlyRevenue->totalActual);
                }else{
                    array_push($data['yearly_revenue'],0);
                }
            }
        }else{
            for ($i=1; $i <= 12 ; $i++) {
                array_push($data['yearly_revenue'],0);
            }
        }

        return response()->json($data, 200);
    }

    public function getSalesPerformance($sales){
        $data = SalesBudget::where('sales',$sales)->whereMonth('period',date('m'))->whereYear('period',date('Y'))->get();

        return DataTables::of($data)
            ->addColumn('achievement_1m', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;


                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->transportLoadGroups)
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
                                        ->whereIn('load_group', $this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date('m'))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->bulkLoadGroups)
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

                $currentMonth = intval(date('m'));
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
                                        ->whereIn('load_group', $this->transportLoadGroups)
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
                                        ->whereIn('load_group', $this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(load_closed_date)'),$ytd_month)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->bulkLoadGroups)
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
                return "<canvas id='".$row->id."' value='".$row->id."' class='table-container-graph' height='75px'><input type='hidden' name='budgetId' value='".$row->id."'></canvas>";
            })
            ->rawColumns(['achievement_1m','achievement_ytd','period_mon','graph'])
            ->make(true);
    }

    public function getDivisionPerformance($division){
        $data = SalesBudget::where('division',$division)->whereMonth('period',date('m'))->whereYear('period',date('Y'))->get();

        return DataTables::of($data)
            ->addColumn('achievement_1m', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;


                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->transportLoadGroups)
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
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date('m'))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }
                else if($row->division == "Bulk Trans"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
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

                $currentMonth = intval(date('m'));
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
                                        ->whereIn('load_group',$this->transportLoadGroups)
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
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(load_closed_date)'),$ytd_month)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
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
                return "<canvas id='".$row->id."' value='".$row->id."' class='table-container-graph' height='75px'><input type='hidden' name='budgetId' value='".$row->id."'></canvas>";
            })
            ->rawColumns(['achievement_1m','achievement_ytd','period_mon','graph'])
            ->make(true);
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
                                        ->whereIn('load_group', $this->transportLoadGroups)
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
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('load_closed_date',date('m'))
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
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

                $currentMonth = intval(date('m'));
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
                                        ->whereIn('load_group',$this->transportLoadGroups)
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
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(load_closed_date)'),$ytd_month)
                                        ->whereYear('load_closed_date',date('Y'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = ShipmentBlujay::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
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
                return "<canvas id='".$row->id."' value='".$row->id."' class='table-container-graph' height='75px'><input type='hidden' name='budgetId' value='".$row->id."'></canvas>";
            })
            ->rawColumns(['achievement_1m','achievement_ytd','period_mon','graph'])
            ->make(true);
    }

    public function getSalesPie($sales){
        $year = date('Y');
        $data['warehouse'] = [10000,20000];
        $data['transport'] = [0,0];
        $data['exim'] = [0,0];
        $data['bulk'] = [0,0];

        //Blujay Transport
        $revenueTransport = 0;
        $budgetTransport = 0;
        $customerTransport = SalesBudget::where('sales',$sales)
                                        ->where('division', 'Pack Trans')
                                        ->whereMonth('period',date('m'))
                                        ->whereYear('period',date('Y'))
                                        ->get();

        foreach ($customerTransport as $c) {
            $budgetTransport += $c->budget;
            $fetchTransport = ShipmentBlujay::selectRaw('SUM(billable_total_rate) as totalActual')
                                    ->where('customer_reference',$c->customer_sap)
                                    ->whereIn('load_group',$this->transportLoadGroups)
                                    ->where('load_status','Completed')
                                    ->whereMonth('load_closed_date',date('m'))
                                    ->whereYear('load_closed_date',date('Y'))
                                    ->first();

            if(!is_null($fetchTransport)){
                $revenueTransport += intval($fetchTransport->totalActual);
            }
        }

        $budgetTransport -= $revenueTransport;
        $data['transport'] = [$revenueTransport,$budgetTransport];

        //Blujay Exim
        $revenueExim = 0;
        $budgetExim = 0;
        $customerExim = SalesBudget::where('sales',$sales)
                                        ->where('division', 'Freight Forwarding BP')
                                        ->whereMonth('period',date('m'))
                                        ->whereYear('period',date('Y'))
                                        ->get();

        foreach ($customerExim as $c) {
            $budgetExim += $c->budget;
            $fetchExim = ShipmentBlujay::selectRaw('SUM(billable_total_rate) as totalActual')
                                    ->where('customer_reference',$c->customer_sap)
                                    ->whereIn('load_group',$this->eximLoadGroups)
                                    ->where('load_status','Completed')
                                    ->whereMonth('load_closed_date',date('m'))
                                    ->whereYear('load_closed_date',date('Y'))
                                    ->first();

            if(!is_null($fetchExim)){
                $revenueExim += intval($fetchExim->totalActual);
            }
        }

        $budgetExim -= $revenueExim;
        $data['exim'] = [$revenueExim,$budgetExim];

        //Blujay Bulk
        $revenueBulk = 0;
        $budgetBulk = 0;
        $customerBulk = SalesBudget::where('sales',$sales)
                                        ->where('division', 'Bulk Trans')
                                        ->whereMonth('period',date('m'))
                                        ->whereYear('period',date('Y'))
                                        ->get();

        foreach ($customerBulk as $c) {
            $budgetBulk += $c->budget;
            $fetchBulk = ShipmentBlujay::selectRaw('SUM(billable_total_rate) as totalActual')
                                    ->where('customer_reference',$c->customer_sap)
                                    ->whereIn('load_group',$this->bulkLoadGroups)
                                    ->where('load_status','Completed')
                                    ->whereMonth('load_closed_date',date('m'))
                                    ->whereYear('load_closed_date',date('Y'))
                                    ->first();

            if(!is_null($fetchBulk)){
                $revenueBulk += intval($fetchBulk->totalActual);
            }
        }

        $budgetBulk -= $revenueBulk;
        $data['bulk'] = [$revenueBulk,$budgetBulk];


        return response()->json($data,200);
    }
}
