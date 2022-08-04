<?php

namespace App\Http\Controllers\Sales;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\Item;
use App\Models\lead_time;
use App\Models\LoadPerformance;
use App\Models\SalesBudget;
use App\Models\ShipmentBlujay;
use App\Models\Suratjalan_greenfields;
use App\Models\Trucks;
use App\Models\unit_surabaya;
use Google\Service\Compute\BackendServiceLocalityLoadBalancingPolicyConfig;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use ReflectionClass;

use function PHPUnit\Framework\isNan;
use function PHPUnit\Framework\isNull;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //Blujay Load Group (Exim, Bulk, Transport)
    private $transportLoadGroups = ['SURABAYA LOG PACK', 'SURABAYA RENTAL', 'SURABAYA RENTAL TRIP', 'SURABAYA TIV LOKAL'];
    private $eximLoadGroups = ['SURABAYA EXIM TRUCKING', 'SURABAYA TIV IMPORT'];
    private $bulkLoadGroups = ['SURABAYA LOG BULK'];
    private $warehouseLoadGroups = ['FLUX WAREHOUSE'];
    private $emptyLoadGroups = ['SURABAYA MOB KOSONGAN'];
    private $surabayaLoadGroups = ['SURABAYA LOG PACK', 'SURABAYA RENTAL', 'SURABAYA RENTAL TRIP', 'SURABAYA TIV LOKAL','SURABAYA EXIM TRUCKING', 'SURABAYA TIV IMPORT','SURABAYA LOG BULK','SURABAYA MOB KOSONGAN'];
    private $surabayaAllDivision = ['FLUX WAREHOUSE' ,'SURABAYA LOG PACK', 'SURABAYA RENTAL', 'SURABAYA RENTAL TRIP', 'SURABAYA TIV LOKAL','SURABAYA EXIM TRUCKING', 'SURABAYA TIV IMPORT','SURABAYA LOG BULK','SURABAYA MOB KOSONGAN'];
    private $rateThreshold = 100;

    //Navigation
    public function showLoadDetail(Request $req, $load_id){
        $data['load_id'] = $load_id;

        $data['performance'] = LoadPerformance::where('tms_id', $load_id)->first();
        $data['shipment'] = ShipmentBlujay::where('load_id', $load_id)->get();

        $data['performance']->net = $data['performance']->billable_total_rate - $data['performance']->payable_total_rate;

        if($data['performance']->net > 0){
            $data['performance']->margin_percentage = floatval($data['performance']->net)/floatval($data['performance']->billable_total_rate) * 100;
            $data['performance']->margin_percentage = round(floatval($data['performance']->margin_percentage), 2);
            
        }else if($data['performance']->net < 0){
            $data['performance']->margin_percentage = floatval($data['performance']->net)/floatval($data['performance']->billable_total_rate) * 100;
            $data['performance']->margin_percentage = round(floatval($data['performance']->margin_percentage), 2);
        }else{
            $data['performance']->margin_percentage = 0;
        }

        //Lead Time
        $leadTime = lead_time::select('ltpod')
                                    ->where('rg_origin','LIKE','%'.$data['performance']->first_pick_location_city.'%')
                                    ->where('rg_destination','LIKE','%'.$data['performance']->last_drop_location_city.'%')
                                    ->orderBy('ltpod','asc')
                                    ->first();
        if($leadTime == null){
            $data['performance']->lead_time = 1;
        }else{
            $data['performance']->lead_time = $leadTime->ltpod;
        }

        return view('sales.pages.pdf.pdf-load-detail',$data);
    }

    public function gotoTruckingPerformance(){
        $today = Carbon::now();
        Session::put('sales-from',$today);
        Session::put('sales-to',$today);
        $data['last_update'] = LoadPerformance::orderBy('updated_at','desc')->first();

        return view('sales.pages.trucking.performance',$data);
    }

    public function gotoTruckingUtility(){
        Session::put('sales-month',date('m'));
        Session::put('sales-year', date('Y'));
        $data['last_update'] = LoadPerformance::orderBy('updated_at','desc')->first();

        return view('sales.pages.trucking.utility',$data);
    }

    public function gotoLandingPage(){
        Session::put('sales-month',date('m'));
        Session::put('sales-year', date('Y'));

        $data['last_update'] = LoadPerformance::orderBy('updated_at','desc')->first();

        return view('sales.pages.landing',$data);
    }

    public function gotoMonitoringMaster(){
        Session::put('sales-month',date('m'));
        Session::put('sales-year', date('Y'));

        return view('sales.pages.monitoring-master');
    }

    public function gotoBySales($sales){
        Session::put('sales-month',date('m'));
        Session::put('sales-year',date('Y'));

        $data['sales'] = $sales;
        $data['sales_list'] = ['adit','edwin','willem'];

        for ($i=0; $i < count($data['sales_list']); $i++) {
            if($data['sales_list'][$i] == $sales){
                unset($data['sales_list'][$i]);
            }
        }

        return view('sales.pages.by-sales', $data);
    }

    public function getSalesOverview($sales){
        //Date Constraint
        $dateConstraint = Session::get('sales-constraint');

        //Status Constraint
        $status = Session::get('sales-status');
        $statusCondition = [
            ['created_date','!=',null]
        ];
        Session::put('sales-status', $status);
        switch ($status) {
            case 'ongoing':
                $statusCondition = [
                    ['load_status','=','Accepted']
                ];
                break;
            case 'pod':
                $statusCondition = [
                    ['load_status','=','Completed'],
                    ['websettle_date','=',null]
                ];
                break;
            case 'websettle':
                $statusCondition = [
                    ['websettle_date','!=',null]
                ];
                break;
        }

        //Data Sales Overview
        $customerList = SalesBudget::where('sales',$sales)
                                ->whereMonth('period',Session::get('sales-month'))
                                ->whereYear('period',Session::get('sales-year'))
                                ->where('customer_sap','!=',0)
                                ->get();
        
        //CM Transaction
        $mPerformance = LoadPerformance::selectRaw('customer_reference, load_group, SUM(billable_total_rate) as totalActual, COUNT(*) as totalLoads')
                                    ->where('load_status','!=','Voided')
                                    ->where($statusCondition)
                                    ->whereIn('load_group',$this->surabayaLoadGroups)
                                    ->whereMonth($dateConstraint,Session::get('sales-month'))
                                    ->whereYear($dateConstraint,Session::get('sales-year'))
                                    ->groupBy('customer_reference','load_group')
                                    ->get();

        $ytdPerformance = LoadPerformance::selectRaw('customer_reference, load_group, SUM(billable_total_rate) as totalActual, COUNT(*) as totalLoads')
                                    ->where('load_status','!=','Voided')
                                    ->where($statusCondition)
                                    ->whereIn('load_group',$this->surabayaLoadGroups)
                                    ->whereMonth($dateConstraint,'<=',Session::get('sales-month'))
                                    ->whereYear($dateConstraint,Session::get('sales-year'))
                                    ->groupBy('customer_reference','load_group')
                                    ->get();

        //CM
        $data['revenue_1m'] = 0;
        $data['transaction_1m'] = 0;

        //YTD
        $data['revenue_ytd'] = 0;
        $data['transaction_ytd'] = 0;

        foreach ($customerList as $c) {
            $division = ['none'];
            switch ($c->division) {
                case 'Pack Trans':
                    $division = $this->transportLoadGroups;
                    break;
                case 'Bulk Trans':
                    $division = $this->bulkLoadGroups;
                    break;
                case 'Freight Forwarding BP':
                    $division = $this->eximLoadGroups;
                    break;
            };

            foreach ($mPerformance as $tempMonth) {
                if(in_array($tempMonth->load_group, $division) && $c->customer_sap == $tempMonth->customer_reference){
                    //CM
                    $data['revenue_1m'] += $tempMonth->totalActual;
                    $data['transaction_1m'] += $tempMonth->totalLoads;
                }
            }

            foreach ($ytdPerformance as $tempYtd) {
                if(in_array($tempYtd->load_group, $division) && $c->customer_sap == $tempYtd->customer_reference){
                    //YTD
                    $data['revenue_ytd'] += $tempYtd->totalActual;
                    $data['transaction_ytd'] += $tempYtd->totalLoads;
                }
            }            
        }

        //ACHIEVEMENT PROGRESS
        $data['budget_1m'] = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                    ->where('sales',$sales)
                                    ->where('customer_sap','!=',0)
                                    ->whereMonth('period',Session::get('sales-month'))
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->first();

        $data['achivement_1m'] = round(floatval($data['revenue_1m'])/floatval($data['budget_1m']->totalBudget),4) * 100;

        $data['budget_ytd'] = 0;
        for ($i=1; $i <= intval(Session::get('sales-month')) ; $i++) {
            $mBudget = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                ->where('sales',$sales)
                                ->where('customer_sap','!=',0)
                                ->whereMonth('period',$i)
                                ->whereYear('period',Session::get('sales-year'))
                                ->first();
            $data['budget_ytd'] += $mBudget->totalBudget;
        }

        $data['achivement_ytd'] = round(floatval($data['revenue_ytd'])/floatval($data['budget_ytd']),4) * 100;

        //formatting data
        $data['achievement_1m_text'] ='('.strval(round($data['revenue_1m']/1000000,0)).'/'.strval(round($data['budget_1m']->totalBudget/1000000,0)).' Mill.) '.strval($data['achivement_1m']).'%';
        $data['achievement_ytd_text'] ='('.strval(round($data['revenue_ytd']/1000000,0)).'/'.strval(round($data['budget_ytd']/1000000,0)).' Mill.) '.strval($data['achivement_ytd']).'%';
        $data['revenue_1m'] = number_format($data['revenue_1m'], 2, ',', '.');
        $data['revenue_ytd'] = number_format($data['revenue_ytd'], 2, ',', '.');
        $data['transaction_1m'] = number_format($data['transaction_1m'], 0, ',', '.');
        $data['transaction_ytd'] = number_format($data['transaction_ytd'], 0, ',', '.');

        return response()->json($data,200);
    }

    public function gotoByDivision($division){
        Session::put('sales-month',date('m'));
        Session::put('sales-year',date('Y'));

        $data['division'] = $division;
        $data['division_list'] = ['transport','bulk','warehouse','exim','kosongan'];

        for ($i=0; $i < count($data['division_list']); $i++) {
            if($data['division_list'][$i] == $division){
                unset($data['division_list'][$i]);
            }
        }

        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = "Pack Trans";
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'bulk':
                $division = "Bulk Trans";
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'exim':
                $division = "Freight Forwarding BP";
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'warehouse':
                $division = "Package Whs";
                $divisionGroup = [];
        }

        return view('sales.pages.by-division', $data);
    }

    public function gotoExportPdf(){
        $today = Carbon::now();
        Session::put('sales-from',$today);
        Session::put('sales-to',$today);

        return view('sales.pages.export-pdf');
    }

    public function getDivisionOverview($division){
        //Date Constraint
        $dateConstraint = Session::get('sales-constraint');

        //Status Constraint
        $status = Session::get('sales-status');
        $statusCondition = [
            ['created_date','!=',null]
        ];
        Session::put('sales-status', $status);
        switch ($status) {
            case 'ongoing':
                $statusCondition = [
                    ['load_status','=','Accepted']
                ];
                break;
            case 'pod':
                $statusCondition = [
                    ['load_status','=','Completed'],
                    ['websettle_date','=',null]
                ];
                break;
            case 'websettle':
                $statusCondition = [
                    ['websettle_date','!=',null]
                ];
                break;
        }

        $divisionGroup = [];

        switch ($division) {
            case 'transport':
                $division = "Pack Trans";
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'bulk':
                $division = "Bulk Trans";
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'exim':
                $division = "Freight Forwarding BP";
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'warehouse':
                $division = "Package Whs";
                $divisionGroup = $this->warehouseLoadGroups;
                break;
            case 'kosongan':
                $division = "Kosongan";
                $divisionGroup = $this->emptyLoadGroups;
                break;
        }

        //Load Performance Data
        $divisionPerformance = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual, count(*) as totalLoads')
                            ->whereIn('load_group',$divisionGroup)
                            ->where('load_status','!=','Voided')
                            ->where($statusCondition)
                            ->whereMonth($dateConstraint,Session::get('sales-month'))
                            ->whereYear($dateConstraint,Session::get('sales-year'))
                            ->first();

        //YTD Data
        $ytdPerformance = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual, count(*) as totalLoads')
                            ->whereIn('load_group',$divisionGroup)
                            ->where('load_status','!=','Voided')
                            ->where($statusCondition)
                            ->whereMonth($dateConstraint,'<=',session::get('sales-month'))
                            ->whereYear($dateConstraint,Session::get('sales-year'))
                            ->first();

        //Revenue
        $data['revenue_1m'] = $divisionPerformance->totalActual;
        $data['revenue_ytd'] = $ytdPerformance->totalActual;

        //Transaction
        $data['transaction_1m'] = $divisionPerformance->totalLoads;
        $data['transaction_ytd'] = $ytdPerformance->totalLoads;

        //Achievement
        //ACHIEVEMENT PROGRESS
        $data['budget_1m'] = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                    ->where('division', $division)
                                    ->whereMonth('period',Session::get('sales-month'))
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->first();
        
        $data['achivement_1m'] = $division=="Kosongan"?100:round(floatval($data['revenue_1m'])/floatval($data['budget_1m']->totalBudget),4) * 100;

        //Achievement Ytd
        $ytdBudget = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                        ->where('division',$division)
                        ->whereMonth('period','<=',Session::get('sales-month'))
                        ->whereYear('period',Session::get('sales-year'))
                        ->first();


        $data['budget_ytd'] = $ytdBudget->totalBudget;

        $data['achivement_ytd'] = $division=="Kosongan"?100:round(floatval($data['revenue_ytd'])/floatval($data['budget_ytd']),4) * 100;

        //formatting data
        $data['achievement_1m_text'] ='('.strval(round($data['revenue_1m']/1000000,0)).'/'.strval(round($data['budget_1m']->totalBudget/1000000,0)).' Mill.) '.strval($data['achivement_1m']).'%';
        $data['achievement_ytd_text'] ='('.strval(round($data['revenue_ytd']/1000000,0)).'/'.strval(round($data['budget_ytd']/1000000,0)).' Mill.) '.strval($data['achivement_ytd']).'%';
        $data['revenue_1m'] = number_format($data['revenue_1m'], 2, ',', '.');
        $data['revenue_ytd'] = number_format($data['revenue_ytd'], 2, ',', '.');
        $data['transaction_1m'] = number_format($data['transaction_1m'], 0, ',', '.');
        $data['transaction_ytd'] = number_format($data['transaction_ytd'], 0, ',', '.');

        return response()->json($data, 200);
    }

    public function getMonthlyAchievement(Request $req){
        $month = Session::get('sales-month');

        //GETTING DATA BY PROGRAM
        //transport
        $fetchTransport = LoadPerformance::selectRaw('DATE(closed_date) as days, SUM(billable_total_rate) as totalActual')
                                    ->whereIn('load_group',$this->transportLoadGroups)
                                    ->whereMonth('closed_date',$month)
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->groupBy('days')
                                    ->get();

        $data['labelTransport'] = [];
        $data['dataTransport'] = [];

        foreach ($fetchTransport as $f) {
            array_push($data['dataTransport'], $f->totalActual);
            array_push($data['labelTransport'], $f->days);
        }

        //exim
        $fetchExim = LoadPerformance::selectRaw('DATE(closed_date) as days, SUM(billable_total_rate) as totalActual')
                                    ->whereIn('load_group',$this->eximLoadGroups)
                                    ->whereMonth('closed_date',$month)
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->groupBy('days')
                                    ->get();


        $data['labelExim'] = [];
        $data['dataExim'] = [];

        foreach ($fetchExim as $f) {
            array_push($data['dataExim'], $f->totalActual);
            array_push($data['labelExim'], $f->days);
        }

        //bulk
        $fetchBulk = LoadPerformance::selectRaw('DATE(closed_date) as days, SUM(billable_total_rate) as totalActual')
                                    ->whereIn('load_group',$this->bulkLoadGroups)
                                    ->whereMonth('closed_date',$month)
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->groupBy('days')
                                    ->get();


        $data['labelBulk'] = [];
        $data['dataBulk'] = [];

        foreach ($fetchBulk as $f) {
            array_push($data['dataBulk'], $f->totalActual);
            array_push($data['labelBulk'], $f->days);
        }

        //Monthly Order
        $completedLoads = count(LoadPerformance::select('tms_id')
                                    ->where('load_status','Completed')
                                    ->whereMonth('closed_date',Session::get('sales-month'))
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->whereIn('load_group',$this->surabayaLoadGroups)
                                    ->groupBy('tms_id')
                                    ->get());

        $incompleteLoads = count(LoadPerformance::select('tms_id')
                                    ->where('load_status','Accepted')
                                    ->where('closed_date',null)
                                    ->whereIn('load_group',$this->surabayaLoadGroups)
                                    ->groupBy('tms_id')
                                    ->get());

        $data['completedLoads'] = $completedLoads;
        $data['incompleteLoads'] = $incompleteLoads;

        return response()->json($data, 200);
    }

    public function getYearlyDetail(Request $req, $division){
        $year = Session::get('sales-year');
        
        $group = $this->surabayaLoadGroups;
        switch ($division) {
            case 'transport':
                $group = $this->transportLoadGroups;
                break;
            case 'exim':
                $group = $this->eximLoadGroups;
                break;
            case 'bulk':
                $group = $this->bulkLoadGroups;
                break;
            case 'warehouse':
                $group = $this->warehouseLoadGroups;
                break;
        }

        $data['revenue'] = LoadPerformance::selectRaw("
                                SUM(billable_total_rate) as totalActual
                            ")
                            ->whereIn('load_group',$group)
                            ->where('billable_total_rate','>',$this->rateThreshold)
                            ->whereYear('created_date',Session::get('sales-year'))
                            ->where('load_status','!=','Voided')
                            ->first();
        $data['revenue'] = number_format(round($data['revenue']->totalActual), 0, ',', '.');
        

        $data['ongoing'] = LoadPerformance::selectRaw("
                                SUM(billable_total_rate) as totalActual
                            ")
                            ->whereIn('load_group',$group)
                            ->where('billable_total_rate','>',$this->rateThreshold)
                            ->whereYear('created_date',Session::get('sales-year'))
                            ->where('load_status','!=','Voided')
                            ->where([
                                ['load_status','=','Accepted']
                            ])
                            ->first();
        $data['ongoing'] = number_format(round($data['ongoing']->totalActual), 0, ',', '.');

        $data['pod'] =  LoadPerformance::selectRaw("
                            SUM(billable_total_rate) as totalActual
                        ")  
                        ->whereIn('load_group',$group)
                        ->where('billable_total_rate','>',$this->rateThreshold)
                        ->whereYear('created_date',Session::get('sales-year'))
                        ->where('load_status','!=','Voided')
                        ->where([
                            ['load_status','=','Completed'],
                            ['websettle_date','=',null]
                        ])
                        ->first();
        $data['pod'] = number_format(round($data['pod']->totalActual), 0, ',', '.');
        
        $data['websettle'] =  LoadPerformance::selectRaw("
                        SUM(billable_total_rate) as totalActual
                    ")  
                    ->whereIn('load_group',$group)
                    ->where('billable_total_rate','>',$this->rateThreshold)
                    ->whereYear('created_date',Session::get('sales-year'))
                    ->where('load_status','!=','Voided')
                    ->where([
                        ['websettle_date','!=',null]
                    ])
                    ->first(); 
        $data['websettle'] = number_format(round($data['websettle']->totalActual), 0, ',', '.');    
        
        return response($data, 200);
    }

    public function getYearlyRevenue (Request $req, $division){
        $year = Session::get('sales-year');
        $data['overall'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $data['ongoing'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $data['pod'] = [0,0,0,0,0,0,0,0,0,0,0,0];
        $data['websettle'] = [0,0,0,0,0,0,0,0,0,0,0,0];

        $group = $this->surabayaAllDivision;
        switch ($division) {
            case 'transport':
                $group = $this->transportLoadGroups;
                break;
            case 'exim':
                $group = $this->eximLoadGroups;
                break;
            case 'bulk':
                $group = $this->bulkLoadGroups;
                break;
            case 'warehouse':
                $group = $this->warehouseLoadGroups;
                break;
        }

        //Blujay Transport
        $fetchOverall = LoadPerformance::selectRaw("
                                        SUM(billable_total_rate) as totalActual,
                                        DATE_FORMAT(created_date,'%m') as monthKey
                                    ")
                                    ->whereIn('load_group',$group)
                                    ->where('billable_total_rate','>',$this->rateThreshold)
                                    ->whereYear('created_date',Session::get('sales-year'))
                                    ->where('load_status','!=','Voided')
                                    ->groupBy('monthKey')
                                    ->get();

        foreach($fetchOverall as $monthlyRevenue){
            $data['overall'][$monthlyRevenue->monthKey-1] = $monthlyRevenue->totalActual;
        }
        
        //Available Labels
        $data['labels'] = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
        //KALO MAU CUT LABEL $data['labels'] = array_slice($data['labels'],0,count($fetchTransport));
        
        //Detail Bar Ongoing
        $fetchOngoing = LoadPerformance::selectRaw("
                                SUM(billable_total_rate) as totalActual,
                                DATE_FORMAT(created_date,'%m') as monthKey
                            ")
                            ->whereIn('load_group',$group)
                            ->where('billable_total_rate','>',$this->rateThreshold)
                            ->whereYear('created_date',Session::get('sales-year'))
                            ->where('load_status','!=','Voided')
                            ->where([
                                ['load_status','=','Accepted']
                            ])
                            ->groupBy('monthKey')
                            ->get();

        foreach($fetchOngoing as $monthlyOngoing){
            $data['ongoing'][$monthlyOngoing->monthKey-1] = $monthlyOngoing->totalActual;
        }

        //Detail Bar POD
        $fetchPod =  LoadPerformance::selectRaw("
                            SUM(billable_total_rate) as totalActual,
                            DATE_FORMAT(created_date,'%m') as monthKey
                        ")  
                        ->whereIn('load_group',$group)
                        ->where('billable_total_rate','>',$this->rateThreshold)
                        ->whereYear('created_date',Session::get('sales-year'))
                        ->where('load_status','!=','Voided')
                        ->where([
                            ['load_status','=','Completed'],
                            ['websettle_date','=',null]
                        ])
                        ->groupBy('monthKey')
                        ->get();
        
        foreach($fetchPod as $monthlyPod){
            $data['pod'][$monthlyPod->monthKey-1] = $monthlyPod->totalActual;
        }
        
        //Detail Bar Websettle
        $fetchWebsettle =  LoadPerformance::selectRaw("
                        SUM(billable_total_rate) as totalActual,
                        DATE_FORMAT(created_date,'%m') as monthKey
                    ")  
                    ->whereIn('load_group',$group)
                    ->where('billable_total_rate','>',$this->rateThreshold)
                    ->whereYear('created_date',Session::get('sales-year'))
                    ->where('load_status','!=','Voided')
                    ->where([
                        ['websettle_date','!=',null]
                    ])
                    ->groupBy('monthKey')
                    ->get();

        foreach($fetchWebsettle as $monthlyWebsettle){
            $data['websettle'][$monthlyWebsettle->monthKey-1] = $monthlyWebsettle->totalActual;
        }


        return response()->json($data,200);
    }

    public function getYearlyAchievement(Request $req, $id){
        $tempBudget = SalesBudget::find($id);

        //Date Constraint
        $dateConstraint = Session::get('sales-constraint');

        //Status Constraint
        $status = Session::get('sales-status');
        $statusCondition = [
            ['created_date','!=',null]
        ];
        Session::put('sales-status', $status);
        switch ($status) {
            case 'ongoing':
                $statusCondition = [
                    ['load_status','=','Accepted']
                ];
                break;
            case 'pod':
                $statusCondition = [
                    ['load_status','=','Completed'],
                    ['websettle_date','=',null]
                ];
                break;
            case 'websettle':
                $statusCondition = [
                    ['websettle_date','!=',null]
                ];
                break;
        }


        $data['message'] = "Sukses mengambil data budget.";
        $data['yearly_budget'] = SalesBudget::where('customer_name',$tempBudget->customer_name)
                                        ->where('division',$tempBudget->division)
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->orderBy('period','asc')
                                        ->get()
                                        ->pluck('budget');

        $data['yearly_revenue'] = [];

        //division
        $divisionGroup = [];
        switch ($tempBudget->division) {
            case 'Pack Trans':
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'Freight Forwarding BP':
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'Bulk Trans':
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'Surabaya':
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }

        //Blujay
        $dbYearlyRevenue = LoadPerformance::selectRaw("
                                            SUM(billable_total_rate) as totalActual,
                                            DATE_FORMAT(".$dateConstraint.",'%m') as monthKey
                                        ")
                                        ->where('customer_reference',$tempBudget->customer_sap)
                                        ->whereIn('load_group',$divisionGroup)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereYear($dateConstraint,Session::get('sales-year'))
                                        ->groupBy('monthKey')
                                        ->get();

        $yearlyRevenue = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($dbYearlyRevenue as $monthlyRevenue){
            $yearlyRevenue[$monthlyRevenue->monthKey-1] = $monthlyRevenue->totalActual;
        }
        
        $data['yearly_revenue'] = $yearlyRevenue;
        return response()->json($data, 200);
    }

    public function getSalesPerformance($sales){
        $data = SalesBudget::where('budget','>',0)->where('sales',$sales)->whereMonth('period',Session::get('sales-month'))->whereYear('period',Session::get('sales-year'))->get();

        return DataTables::of($data)
            ->addColumn('achievement_1m', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;


                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
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

                $currentMonth = intval(Session::get('sales-month'));
                $ytd_month = [];

                for ($i=1; $i <= $currentMonth; $i++) {
                    array_push($ytd_month,$i);
                    //error_log($i);
                }

                $ytd_budget = SalesBudget::selectRaw('customer_name, SUM(budget) as budget')
                                        ->where('customer_name','=',$row->customer_name)
                                        ->where('division',$row->division)
                                        ->whereIn(DB::raw('month(period)'),$ytd_month)
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->groupBy('customer_name')
                                        ->first();



                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT

                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
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
        $data = SalesBudget::where('budget','>',0)->where('division',$division)->whereMonth('period',Session::get('sales-month'))->whereYear('period',Session::get('sales-year'))->get();

        return DataTables::of($data)
            ->addColumn('achievement_1m', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;


                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }
                else if($row->division == "Bulk Trans"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
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

                $currentMonth = intval(Session::get('sales-month'));
                $ytd_month = [];

                for ($i=1; $i <= $currentMonth; $i++) {
                    array_push($ytd_month,$i);
                    //error_log($i);
                }

                $ytd_budget = SalesBudget::selectRaw('customer_name, SUM(budget) as budget')
                                        ->where('customer_name','=',$row->customer_name)
                                        ->where('division',$row->division)
                                        ->whereIn(DB::raw('month(period)'),$ytd_month)
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->groupBy('customer_name')
                                        ->first();



                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT

                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
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
        $data = SalesBudget::where('budget','>',0)->whereMonth('period',Session::get('sales-month'))->whereYear('period',Session::get('sales-year'))->get();

        return DataTables::of($data)
            ->addColumn('achievement_1m', function($row){
                //actual data
                $actual = 0;
                $percentage = 0;


                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group', $this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
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

                $currentMonth = intval(Session::get('sales-month'));
                $ytd_month = [];

                for ($i=1; $i <= $currentMonth; $i++) {
                    array_push($ytd_month,$i);
                    //error_log($i);
                }

                $ytd_budget = SalesBudget::selectRaw('customer_name, SUM(budget) as budget')
                                        ->where('customer_name','=',$row->customer_name)
                                        ->where('division',$row->division)
                                        ->whereIn(DB::raw('month(period)'),$ytd_month)
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->groupBy('customer_name')
                                        ->first();



                if($row->division == "Pack Trans"){
                    //BLUJAY DIVISION TRANSPORT

                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->transportLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Freight Forwarding BP"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->groupBy('customer_reference')
                                        ->first();

                    if(!is_null($total)){
                        $actual = $total->totalActual;
                    }
                }else if($row->division == "Bulk Trans"){
                    $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$row->customer_sap)
                                        ->whereIn('load_group',$this->bulkLoadGroups)
                                        ->where('load_status','Completed')
                                        ->whereIn(DB::raw('month(closed_date)'),$ytd_month)
                                        ->whereYear('closed_date',Session::get('sales-year'))
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
        $month = Session::get('sales-month');
        $year = Session::get('sales-year');

        //Date Constraint
        $dateConstraint = Session::get('sales-constraint');

        //Status Constraint
        $status = Session::get('sales-status');
        $statusCondition = [
            ['created_date','!=',null]
        ];
        Session::put('sales-status', $status);
        switch ($status) {
            case 'ongoing':
                $statusCondition = [
                    ['load_status','=','Accepted']
                ];
                break;
            case 'pod':
                $statusCondition = [
                    ['load_status','=','Completed'],
                    ['websettle_date','=',null]
                ];
                break;
            case 'websettle':
                $statusCondition = [
                    ['websettle_date','!=',null]
                ];
                break;
        }

        $budget = SalesBudget::where('sales',$sales)
                            ->whereMonth('period', $month)
                            ->whereYear('period', $year)
                            ->where('customer_sap','!=',0)
                            ->get();

        //CM Transaction
        $mPerformance = LoadPerformance::selectRaw('customer_reference, load_group, SUM(billable_total_rate) as totalActual, COUNT(*) as totalLoads')
                                    ->where('load_status','!=','Voided')
                                    ->where($statusCondition)
                                    ->whereIn('load_group',$this->surabayaLoadGroups)
                                    ->whereMonth($dateConstraint,Session::get('sales-month'))
                                    ->whereYear($dateConstraint,Session::get('sales-year'))
                                    ->groupBy('customer_reference','load_group')
                                    ->get();
        $transportCustomer = [];
        $eximCustomer = [];
        $bulkCustomer = [];
        $warehouseCustomer = [];
        $transportBudgets = 0;
        $eximBudgets = 0;
        $bulkBudgets = 0;
        $warehouseBudgets = 0;

        $salesCustomer = [];

        foreach ($budget as $b) {
            if($b->division == "Pack Trans"){
                array_push($transportCustomer, $b->customer_sap);
                $transportBudgets += $b->budget;
            }else if($b->division == "Freight Forwarding BP"){
                array_push($eximCustomer, $b->customer_sap);
                $eximBudgets += $b->budget;
            }else if($b->division == "Bulk Trans"){
                array_push($bulkCustomer, $b->customer_sap);
                $bulkBudgets += $b->budget;
            }else if($b->division == "Package Whs"){
                array_push($warehouseCustomer, $b->customer_sap);
                $warehouseBudgets += $b->budget;
            }
        }
        
        $actualTransport = 0;
        $actualExim = 0;
        $actualBulk = 0;
        $actualWarehouse = 0;

        $loadTransport = 0;
        $loadExim = 0;
        $loadBulk = 0;
        $loadWarehouse = 0;

        foreach ($mPerformance as $load) {
            //Division Actual
            if(in_array($load->customer_reference,$transportCustomer) && in_array($load->load_group, $this->transportLoadGroups)){
                $actualTransport += $load->totalActual;
                $loadTransport += $load->totalLoads;
            }else if(in_array($load->customer_reference,$eximCustomer) && in_array($load->load_group, $this->eximLoadGroups)){
                $actualExim += $load->totalActual;
                $loadExim += $load->totalLoads;
            }else if(in_array($load->customer_reference,$bulkCustomer) && in_array($load->load_group, $this->bulkLoadGroups)){
                $actualBulk += $load->totalActual;
                $loadBulk += $load->totalLoads;
            }else if(in_array($load->customer_reference,$warehouseCustomer) && in_array($load->load_group, $this->warehouseLoadGroups)){
                $actualWarehouse += $load->totalActual;
                $loadWarehouse += $load->totalLoads;
            }
        }

        //Assign Output Data
        $data['warehouse'] = [0,0,0];
        $data['transport'] = [$actualTransport, $transportBudgets-$actualTransport, $loadTransport];
        $data['exim'] = [$actualExim, $eximBudgets-$actualExim, $loadExim];
        $data['bulk'] = [$actualBulk, $bulkBudgets-$actualBulk, $loadBulk];


        return response()->json($data,200);
    }

    public function getDivisionPie($division){
        $year = Session::get('sales-year');
        $reservedCustomer = [];
        $data['adit'] = [0,0];
        $data['edwin'] = [0,0];
        $data['willem'] = [0,0];
        $data['unlocated'] = [0,0];
        $data['unlocated_customer'] = [];

        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = "Pack Trans";
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'bulk':
                $division = "Bulk Trans";
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'exim':
                $division = "Freight Forwarding BP";
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'warehouse':
                $division = "Package Whs";
                $divisionGroup = [];
            case 'kosongan':
                $division = "kosongan";
                $divisionGroup = $this->emptyLoadGroups;
        }

        if($division != "kosongan"){
            //Blujay Adit
            $revenueAdit = 0;
            $budgetAdit = 0;

            $customerAdit = SalesBudget::where('division',$division)
                                        ->where('sales', 'adit')
                                        ->whereMonth('period',Session::get('sales-month'))
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->get();

            foreach ($customerAdit as $c) {
                $budgetAdit += $c->budget;
                $fetchAdit = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$c->customer_sap)
                                        ->whereIn('load_group',$divisionGroup)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->first();

                if(!is_null($fetchAdit)){
                    $revenueAdit += intval($fetchAdit->totalActual);
                }
            }

            $budgetAdit -= $revenueAdit;
            $data['adit'] = [$revenueAdit,$budgetAdit];

            //Blujay Edwin
            $revenueEdwin = 0;
            $budgetEdwin = 0;

            $customerEdwin = SalesBudget::where('division',$division)
                                        ->where('sales', 'edwin')
                                        ->whereMonth('period',Session::get('sales-month'))
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->get();

            foreach ($customerEdwin as $c) {
                $budgetEdwin += $c->budget;
                $fetchEdwin = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$c->customer_sap)
                                        ->whereIn('load_group',$divisionGroup)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->first();

                if(!is_null($fetchEdwin)){
                    $revenueEdwin += intval($fetchEdwin->totalActual);
                }
            }

            $budgetEdwin -= $revenueEdwin;
            $data['edwin'] = [$revenueEdwin,$budgetEdwin];

            //Blujay Willem
            $revenueWillem = 0;
            $budgetWillem = 0;

            $customerWillem = SalesBudget::where('division',$division)
                                        ->where('sales', 'willem')
                                        ->whereMonth('period',Session::get('sales-month'))
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->get();

            foreach ($customerWillem as $c) {
                $budgetWillem += $c->budget;
                $fetchWillem = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->where('customer_reference',$c->customer_sap)
                                        ->whereIn('load_group',$divisionGroup)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->first();

                if(!is_null($fetchWillem)){
                    $revenueWillem += intval($fetchWillem->totalActual);
                }
            }

            $budgetWillem -= $revenueWillem;
            $data['willem'] = [$revenueWillem,$budgetWillem];

            //Blujay UNLOCATED
            $listedCustomer = [];
            foreach ($customerAdit as $c) {
                array_push($listedCustomer, $c->customer_sap);
            }
            foreach ($customerEdwin as $c) {
                array_push($listedCustomer, $c->customer_sap);
            }
            foreach ($customerWillem as $c) {
                array_push($listedCustomer, $c->customer_sap);
            }
            

            $revenueUnlocated = 0;
            $budgetUnlocated = 0;

            $fetchUnlocated = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereNotIn('customer_reference',$listedCustomer)
                                        ->whereIn('load_group',$divisionGroup)
                                        ->where('load_status','Completed')
                                        ->whereMonth('closed_date',Session::get('sales-month'))
                                        ->whereYear('closed_date',Session::get('sales-year'))
                                        ->first();

            $revenueUnlocated = $fetchUnlocated->totalActual;
            $budgetUnlocated -= $revenueUnlocated;
            $data['unlocated'] = [$revenueUnlocated,0];

            //Listing unlocated customer
            $unlocated_reference = LoadPerformance::select('customer_reference')
                                                ->whereNotIn('customer_reference',$listedCustomer)
                                                ->whereIn('load_group',$divisionGroup)
                                                ->where('load_status','Completed')
                                                ->whereMonth('closed_date',Session::get('sales-month'))
                                                ->whereYear('closed_date',Session::get('sales-year'))
                                                ->groupBy('customer_reference')
                                                ->get()->pluck('customer_reference');
            
            $data['unlocated_customer'] = Customer::whereIn('reference',$unlocated_reference)->get();
        }else{

        }
        

        return response()->json($data,200);
    }

    public function filterSalesDate($month, $year){
        Session::put('sales-month', $month);
        Session::put('sales-year', $year);

        return response()->json(['message' => "success"], 200);
    }

    public function filterSalesDateBetween($fromDate, $fromMonth, $fromYear, $toDate, $toMonth, $toYear){
        $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate.'/'.($fromMonth+1).'/'.$fromYear);
        $toDate = Carbon::createFromFormat('d/m/Y', $toDate.'/'.($toMonth+1).'/'.$toYear);

        Session::put('sales-from', $fromDate);
        Session::put('sales-to', $toDate);

        return response()->json(['message' => "success"], 200);
    }

    function dismount($object) {
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }
        return $array;
    }

    public function getAllDivisionPie(){
        $data['transport'] = [0,0];
        $data['exim'] = [0,0];
        $data['bulk'] = [0,0];

        //Blujay Transport
        $revenueTransport = 0;
        $budgetTransport = 0;
        $customerTransport = SalesBudget::where('division', 'Pack Trans')
                                        ->whereMonth('period',Session::get('sales-month'))
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->get();
        $data['transportCust'] = $this->dismount($customerTransport);
        foreach ($customerTransport as $c) {
            $budgetTransport += $c->budget;
        }

        $fetchTransport = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                    ->whereIn('customer_reference',array_column($data['transportCust']['items'], 'customer_sap'))
                                    ->whereIn('load_group',$this->transportLoadGroups)
                                    ->where('load_status','Completed')
                                    ->whereMonth('closed_date',Session::get('sales-month'))
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->first();

        if(!is_null($fetchTransport)){
            $revenueTransport += intval($fetchTransport->totalActual);
        }

        $budgetTransport -= $revenueTransport;
        $data['transport'] = [$revenueTransport,$budgetTransport];

        //Blujay Exim
        $revenueExim = 0;
        $budgetExim = 0;
        $customerExim = SalesBudget::where('division', 'Freight Forwarding BP')
                                        ->whereMonth('period',Session::get('sales-month'))
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->get();
        $data['eximCust'] = $this->dismount($customerExim);

        foreach ($customerExim as $c) {
            $budgetExim += $c->budget;
        }

        $fetchExim = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                    ->whereIn('customer_reference',array_column($data['eximCust']['items'], 'customer_sap'))
                                    ->whereIn('load_group',$this->eximLoadGroups)
                                    ->where('load_status','Completed')
                                    ->whereMonth('closed_date',Session::get('sales-month'))
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->first();

        if(!is_null($fetchExim)){
            $revenueExim += intval($fetchExim->totalActual);
        }

        $budgetExim -= $revenueExim;
        $data['exim'] = [$revenueExim,$budgetExim];

        //Blujay Bulk
        $revenueBulk = 0;
        $budgetBulk = 0;
        $customerBulk = SalesBudget::where('division', 'Bulk Trans')
                                        ->whereMonth('period',Session::get('sales-month'))
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->get();
        $data['bulkCust'] = $this->dismount($customerBulk);

        foreach ($customerBulk as $c) {
            $budgetBulk += $c->budget;
        }

        $fetchBulk = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                    ->whereIn('customer_reference',array_column($data['bulkCust']['items'], 'customer_sap'))
                                    ->whereIn('load_group',$this->bulkLoadGroups)
                                    ->where('load_status','Completed')
                                    ->whereMonth('closed_date',Session::get('sales-month'))
                                    ->whereYear('closed_date',Session::get('sales-year'))
                                    ->first();

        if(!is_null($fetchBulk)){
            $revenueBulk += intval($fetchBulk->totalActual);
        }

        $budgetBulk -= $revenueBulk;
        $data['bulk'] = [$revenueBulk,$budgetBulk];

        return response()->json($data,200);
    }

    public function getFilteringCustomer(Request $req, $division, $sales){
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                break;
            case 'warehouse':
                $division = 'Package Whs';
                break;
            default:
                break;
        }

        $customer_sap = SalesBudget::select('customer_sap')
                                    ->where('division','LIKE',$division=="all"?'%%':'%'.$division.'%')
                                    ->where('sales','LIKE',$sales=="all"?'%%':'%'.$sales.'%')
                                    ->where('customer_sap','!=',0)
                                    ->groupBy('customer_sap')
                                    ->get()
                                    ->pluck('customer_sap');
        $customer = Customer::whereIn('reference',$customer_sap)->get();

        $data['customer'] = $customer;
        return response()->json($data, 200);
    }

    public function generateSalesReport(Request $req, $dateConstraint, $status, $division, $sales, $customer, $isDatatable){
        Session::put('sales-constraint',$dateConstraint);
        //status constraint
        $statusCondition = [
            ['created_date','!=',null]
        ];
        Session::put('sales-status', $status);
        $data['status_constraint'] = $status;
        switch ($status) {
            case 'ongoing':
                $statusCondition = [
                    ['load_status','=','Accepted']
                ];
                break;
            case 'pod':
                $statusCondition = [
                    ['load_status','=','Completed'],
                    ['websettle_date','=',null]
                ];
                break;
            case 'websettle':
                $statusCondition = [
                    ['websettle_date','!=',null]
                ];
                break;
        }

        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                break;
            case 'warehouse':
                $division = 'Package Whs';
                break;
            default:
                break;
        }

        //Data Filtering
        $data['budgets'] = SalesBudget::where('budget','>',0)
                                    ->where('division','LIKE',$division=='all'?'%%':'%'.$division.'%')
                                    ->where('sales','LIKE',$sales=='all'?'%%':'%'.$sales.'%')
                                    ->where('customer_sap','LIKE',$customer=='all'?'%%':'%'.$customer.'%')
                                    ->whereMonth('period',Session::get('sales-month'))
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->get();

        //Actual Period Data
        $loadList = LoadPerformance::selectRaw('customer_reference, load_group, SUM(billable_total_rate) as totalActual')
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereNotNull($dateConstraint)
                                        ->whereBetween($dateConstraint, [Session::get('sales-from'),Session::get('sales-to')])
                                        ->groupBy('customer_reference','load_group')
                                        ->get();

        //YTD Month Filter
        $currentMonth = intval(Session::get('sales-month'));
        $ytd_month = [];

        for ($i=1; $i <= $currentMonth; $i++) {
            array_push($ytd_month,$i);
        }

        //YTD Budget
        $ytd_budget = SalesBudget::selectRaw('customer_sap, division, SUM(budget) as budget')
                                ->whereIn(DB::raw('month(period)'), $ytd_month)
                                ->whereYear('period',Session::get('sales-year'))
                                ->groupBy('customer_sap', 'division')
                                ->get();

        //YTD Actual
        $ytd_actual = LoadPerformance::selectRaw('customer_reference, load_group, SUM(billable_total_rate) as totalActual')
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereIn(DB::raw('month('.$dateConstraint.')'),$ytd_month)
                                        ->whereYear($dateConstraint,Session::get('sales-year'))
                                        ->groupBy('customer_reference','load_group')
                                        ->get();

        foreach ($data['budgets'] as $row) {
            //1MONTH ACHIEVEMENT
            //actual data
            $actual = 0;
            $percentage = 0;

            $loadGroup = "";
            switch ($row->division) {
                case 'Pack Trans':
                    $loadGroup = $this->transportLoadGroups;
                    break;
                case 'Freight Forwarding BP':
                    $loadGroup = $this->eximLoadGroups;
                    break;
                case 'Bulk Trans':
                    $loadGroup = $this->bulkLoadGroups;
                    break;
                case 'Package Whs':
                    $loadGroup = $this->warehouseLoadGroups;
                    break;  
            }

            //REVISI ALGORITHM BARU
            $actual = 0;
            foreach ($loadList as $performance) {
                if($performance->customer_reference == $row->customer_sap && in_array($performance->load_group, $loadGroup)){
                    $actual += $performance->totalActual;
                }
            }

            

            if($row->budget > 0){
                $percentage = floatval($actual)/floatval($row->budget) * 100;
                $percentage = round(floatval($percentage), 2);
            }

            
            $row->achievement_1m_raw = $actual;
            $row->achievement_1m_actual = number_format($actual,0,',','.');
            $row->achievement_1m_budget = number_format($row->budget,0,',','.');
            $row->achievement_1m_percentage = $percentage;

            //YTD ACHIEVEMENT
            //actual data
            $actual = 0;
            $percentage = 0;

            /* ALGORITHM LAMA

            $ytd_budget = SalesBudget::selectRaw('customer_name, SUM(budget) as budget')
                                    ->where('customer_name','=',$row->customer_name)
                                    ->where('division',$row->division)
                                    ->whereIn(DB::raw('month(period)'),$ytd_month)
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->groupBy('customer_name')
                                    ->first();

            $total = LoadPerformance::selectRaw('customer_reference, SUM(billable_total_rate) as totalActual')
                                ->where('customer_reference',$row->customer_sap)
                                ->whereIn('load_group',$loadGroup)
                                ->where('load_status','!=','Voided')
                                ->where($statusCondition)
                                ->whereIn(DB::raw('month('.$dateConstraint.')'),$ytd_month)
                                ->whereYear($dateConstraint,Session::get('sales-year'))
                                ->groupBy('customer_reference')
                                ->first();

            if(!is_null($total)){
                $actual = $total->totalActual;
            }

            */

            //ALGORITHM BARU

            //YTD Budget Row
            $total_ytd_budget = 0;
            foreach ($ytd_budget as $row_ytd_budget) {
                if($row_ytd_budget->division == $row->division && $row_ytd_budget->customer_sap == $row->customer_sap){
                    $total_ytd_budget += $row_ytd_budget->budget;
                }
            }

            //YTD Actual Row
            $total_ytd_actual = 0;
            foreach ($ytd_actual as $row_ytd_actual) {
                if($row_ytd_actual->customer_reference == $row->customer_sap && in_array($row_ytd_actual->load_group, $loadGroup)){
                    $total_ytd_actual += $row_ytd_actual->totalActual;
                }
            }


            if($row->budget > 0){
                $percentage = floatval($total_ytd_actual)/floatval($total_ytd_budget) * 100;
                $percentage = round(floatval($percentage), 2);
            }

            $row->achievement_ytd_raw = $total_ytd_actual;
            $row->achievement_ytd_actual = number_format($total_ytd_actual,0,',','.');
            $row->achievement_ytd_budget = number_format($total_ytd_budget,0,',','.');
            $row->achievement_ytd_percentage = $percentage;
            if($percentage > 90){
                $row->achievement_ytd_color = 'text-green-700';
            }else if($percentage > 75){
                $row->achievement_ytd_color = 'text-green-500';
            }else if($percentage > 50){
                $row->achievement_ytd_color = 'text-yellow-300';
            }else if($percentage > 25){
                $row->achievement_ytd_color = 'text-orange-400';
            }else if($percentage > 10){
                $row->achievement_ytd_color = 'text-orange-600';    
            }else{
                $row->achievement_ytd_color = 'text-red-600';    
            }
        }

        $data['budgets'] = collect($data['budgets'])->sortBy('division')->sortBy('achievement_ytd_raw')->reverse();

        $data['period'] = Carbon::create()->month(Session::get('sales-month'))->format('F')." ".Session::get('sales-year');
        $data['period_year'] = Session::get('sales-year');

        //Graph Data 1 Year
        //Transport
        $actualTransport = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->transportLoadGroups)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereYear($dateConstraint,Session::get('sales-year'))
                                        ->first();

        $budgetTransport = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                    ->where('division','Pack Trans')
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->first();

        if(!is_null($actualTransport) && !is_null($budgetTransport)){
            $actualTransport = $actualTransport->totalActual;
            $budgetTransport = $budgetTransport->totalBudget;
            $data['achievement_transport'] = [$actualTransport, $budgetTransport];
        }

        //Exim
        $actualExim = 0;
        $actualExim = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->eximLoadGroups)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereYear($dateConstraint,Session::get('sales-year'))
                                        ->first();

        $budgetExim = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                    ->where('division','Freight Forwarding BP')
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->first();

        if(!is_null($actualExim) && !is_null($budgetExim)){
            $actualExim = $actualExim->totalActual;
            $budgetExim = $budgetExim->totalBudget;
            $data['achievement_exim'] = [$actualExim, $budgetExim];
        }

        //Bulk
        $actualBulk = 0;
        $actualBulk = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->bulkLoadGroups)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereYear($dateConstraint,Session::get('sales-year'))
                                        ->first();

        $budgetBulk = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                    ->where('division','Bulk Trans')
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->first();

        if(!is_null($actualBulk) && !is_null($budgetBulk)){
            $actualBulk = $actualBulk->totalActual;
            $budgetBulk = $budgetBulk->totalBudget;
            $data['achievement_bulk'] = [$actualBulk, $budgetBulk];
        }

        //Warehouse
        $actualWarehouse = 0;
        $actualWarehouse = LoadPerformance::selectRaw('SUM(billable_total_rate) as totalActual')
                                        ->whereIn('load_group',$this->warehouseLoadGroups)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereYear($dateConstraint,Session::get('sales-year'))
                                        ->first();

        $budgetWarehouse = SalesBudget::selectRaw('SUM(budget) as totalBudget')
                                    ->where('division','Package Whs')
                                    ->whereYear('period',Session::get('sales-year'))
                                    ->first();

        if(!is_null($actualWarehouse) && !is_null($budgetWarehouse)){
            $actualWarehouse = $actualWarehouse->totalActual;
            $budgetWarehouse = $budgetWarehouse->totalBudget;
            $data['achievement_warehouse'] = [$actualWarehouse, $budgetWarehouse];
        }

        //Show Specific Sales Performance
        $data['sales'] = $sales;

        //1 Month Graph Data

        //Return Output
        if($isDatatable == 'true'){
            return DataTables::of($data['budgets'])
            ->addColumn('period_mon', function($row){
                return date('M-Y',strtotime($row->period));
            })
            ->addColumn('graph', function($row){
                return "<canvas id='".$row->id."' value='".$row->id."' class='table-container-graph' height='75px'><input type='hidden' name='budgetId' value='".$row->id."'></canvas>";
            })
            ->rawColumns(['achievement_1m','achievement_ytd','period_mon','graph'])
            ->make(true);
        }else if($isDatatable == 'false'){
            return view('sales.pages.pdf.pdf-overall', $data);
        }else if($isDatatable == 'single'){
            $data['customer'] = LoadPerformance::select('customer_reference','customer_name')
                                                ->where('customer_reference',$customer)
                                                ->first();

            return view('sales.pages.pdf.pdf-single-customer', $data);
        }
    }

    public function getDailyUpdate(Request $req, $section, $step)
    {
        //DATE CRAWL
        $latestInput = LoadPerformance::selectRaw("DATE_FORMAT(created_date, '%Y-%b-%d') as created_date_format")
                                    ->whereIn('load_group',$this->surabayaLoadGroups)
                                    ->where('billable_total_rate','>',$this->rateThreshold)
                                    ->groupBy('created_date_format')
                                    ->orderBy('created_date','desc')
                                    ->get();

        if(Carbon::parse($latestInput[0]->created_date_format)->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
            $latestInput = $latestInput[1];
        }else{
            $latestInput = $latestInput[0];
        }

        $latestDate = Carbon::parse($latestInput->created_date_format);

        //Date Filtering
        $subDay = 0;
        $subDayBefore = 0;

        //SUB DAY H-1 CONSTRAINT
        if($latestDate->dayName == "Saturday"){
            $subDay = 1;
        }else if($latestDate->dayName == "Sunday"){
            $subDay = 2;
        }
        $latestDate = $latestDate->subDays($subDay);

        //SUB DAY H-2
        if($latestDate->dayName == "Monday"){
            $subDayBefore = 3;
        }else{
            $subDayBefore = 1;
        }

        //special step
        if($step != 1){
            $subDayBefore = $step;
        }

        if($step == "mtd" || $step =="ytd"){
            $subDayBefore = 0;
        }

        $latestDateBefore = Carbon::parse($latestInput->created_date_format)->subDays($subDay+$subDayBefore);

        $data['dayNameBefore'] = $latestDateBefore->dayName." ( ".$latestDateBefore->format('Y-m-d')." ) ";
        
        if($step == "mtd"){
            $latestDateBefore = $latestDateBefore->format('Y-m')."-01";
        }else if($step == "ytd"){
            $latestDateBefore = $latestDateBefore->format('Y')."-01-01";
        }else{
            $latestDateBefore = $latestDateBefore->format('Y-m-d');
        }
        
        
        $data['dayName'] = $latestDate->dayName." ( ".$latestDate->format('Y-m-d')." ) ";
        $latestDate = $latestDate->format('Y-m-d');

        //HEADLINE SECTIONS
        if($section == "marquee"){
            //Section : Daily Data Crawling
            $data['yesterday'] = LoadPerformance::selectRaw('SUM(billable_total_rate) as revenue, count(tms_id) as totalLoads, count(DISTINCT vehicle_number) as totalVehicle, customer_reference, customer_name')
                                            ->whereDate('created_date','=', $latestDate)
                                            ->groupBy('customer_reference','customer_name')
                                            ->whereIn('load_group',$this->surabayaLoadGroups)
                                            ->where('billable_total_rate','>',$this->rateThreshold)
                                            ->get();

            $beforeYesterday = LoadPerformance::selectRaw('SUM(billable_total_rate) as revenue, count(tms_id) as totalLoads, customer_reference, customer_name')
                                            ->whereDate('created_date','=', $latestDateBefore)
                                            ->groupBy('customer_reference','customer_name')
                                            ->where('billable_total_rate','>',$this->rateThreshold)
                                            ->whereIn('load_group',$this->surabayaLoadGroups)
                                            ->get();

            foreach ($data['yesterday'] as $y) {
                if($y->customer_reference==""){
                    $y->customer_name = "UNDEFINED";
                }
                $y->revenue_format = number_format($y->revenue, 2, ',', '.');
                $y->margin = "None";
                $y->margin_percentage = "None";
                foreach ($beforeYesterday as $b) {
                    if($y->customer_reference == $b->customer_reference){
                        $y->margin = $y->revenue - $b->revenue;
                        $y->margin_percentage = round(($y->margin/$b->revenue)*100,2);
                        if($y->margin_percentage > 100)$y->margin_percentage="100+";
                        if($y->margin_percentage < -100)$y->margin_percentage="100-";
                    }
                }
            }
        }else if($section == "pod"){
            //Section: POD Progress
            $data['pod'] = LoadPerformance::selectRaw('customer_reference, customer_name, count(*) as totalPod')
                            ->whereDate('closed_date','<=',$latestDate)
                            ->whereDate('closed_date','>=',$step==1?$latestDate:$latestDateBefore)
                            ->whereIn('load_group',$this->surabayaLoadGroups)
                            ->where('billable_total_rate','>',$this->rateThreshold)
                            ->groupBy('customer_reference','customer_name')
                            ->get();

            $totalAccepted = LoadPerformance::selectRaw('customer_reference, customer_name, count(*) as totalAccepted, 0 as hasPod')
                                ->whereDate('created_date','<=',$latestDate)
                                ->where('load_status',"Accepted")
                                ->whereIn('load_group',$this->surabayaLoadGroups)
                                ->where('billable_total_rate','>',$this->rateThreshold)
                                ->groupBy('customer_reference','customer_name')
                                ->get();
                            
            //POD COMPARISON
            foreach ($data['pod'] as $pod) {
                $pod->totalAccepted = $pod->totalPod;
                foreach ($totalAccepted as $accepted) {
                    if($accepted->customer_reference == $pod->customer_reference){
                        $accepted->hasPod = 1;
                        $pod->totalAccepted = $pod->totalPod + $accepted->totalAccepted;
                    }
                }
                $pod->margin_percentage = round(($pod->totalPod / $pod->totalAccepted)*100, 2);
            }
            
            $data['accepted'] = $totalAccepted;
            //Sorting
            $data['pod'] = collect($data['pod'])->sortBy('totalPod')->reverse();
        }else if($section == "websettle"){
            //Section : Daily Websettle Progress
            $data['websettle'] = LoadPerformance::selectRaw('customer_reference, customer_name, count(*) as totalWebsettle')
                                ->whereDate('websettle_date','<=',$latestDate)
                                ->whereDate('websettle_date','>=',$step==1?$latestDate:$latestDateBefore)
                                ->whereIn('load_group',$this->surabayaLoadGroups)
                                ->where('billable_total_rate','>',$this->rateThreshold)
                                ->groupBy('customer_reference','customer_name')
                                ->get();

            $totalPod = LoadPerformance::selectRaw('customer_reference, customer_name, count(*) as totalPod, 0 as hasWebsettle')
                                ->whereDate('closed_date','<=',$latestDate)
                                ->where('websettle_date',null)
                                ->whereIn('load_group',$this->surabayaLoadGroups)
                                ->where('billable_total_rate','>',$this->rateThreshold)
                                ->groupBy('customer_reference','customer_name')
                                ->get();

            //WEBSETTLE COMPARISON
            foreach ($data['websettle'] as $websettle) {
                $websettle->totalPod = $websettle->totalWebsettle;
                foreach ($totalPod as $pod) {
                    if($pod->customer_reference == $websettle->customer_reference){
                        $pod->hasWebsettle = 1;
                        $websettle->totalPod = $websettle->totalWebsettle + $pod->totalPod;
                    }
                }

                $websettle->margin_percentage = round(($websettle->totalWebsettle / $websettle->totalPod)*100 ,2);
            }

            //Sorting
            $data['pod'] = $totalPod;
            $data['websettle'] = collect($data['websettle'])->sortBy('totalWebsettle')->reverse();
        }else if($section == "profit"){
            //Section : Daily Revenue
            $data['gainer'] = LoadPerformance::selectRaw('customer_reference, customer_name, SUM(billable_total_rate) as totalBillable, SUM(payable_total_rate) as totalPayable')
                                            ->whereIn('load_group',$this->surabayaLoadGroups)
                                            ->where('billable_total_rate','>',$this->rateThreshold)
                                            ->whereDate('created_date','<=',$latestDate)
                                            ->whereDate('created_date','>=',$step==1?$latestDate:$latestDateBefore)
                                            ->groupBy('customer_reference','customer_name')
                                            ->get();
            foreach ($data['gainer'] as $gain) {
                $gain->profit = $gain->totalBillable - $gain->totalPayable;
                $gain->profit_format = number_format($gain->profit, 2, ',', '.');
                $gain->margin_percentage = round(($gain->profit / $gain->totalBillable)*100,2);
            }

            //Sorting
            $data['gainer'] = collect($data['gainer'])->sortBy('profit')->reverse();
        }else if($section == "utility"){
            //Section : Daily Utility
            $nopolList = unit_surabaya::get();
            
            $data['utility'] = LoadPerformance::selectRaw('vehicle_number, MAX(created_date) as latest, MAX(tms_id) as latest_id')
                                            ->whereDate('created_date','<=',$latestDate)
                                            ->whereIn('vehicle_number',$nopolList->pluck('nopol'))
                                            ->groupBy('vehicle_number')
                                            ->orderBy('latest')
                                            ->get();
            
            $latestLoads = LoadPerformance::whereIn('tms_id',$data['utility']->pluck('latest_id'))->get();

            foreach ($data['utility'] as $utility) {
                $utility->load = "NONE";

                

                foreach ($latestLoads as $load) {
                    if($utility->latest_id == $load->tms_id){
                        $utility->load = $load;
                        //Date Range Between Last Load
                        $utility->range = Carbon::parse($load->created_date)->diffInDays(Carbon::now());
                    }
                }

                foreach ($nopolList as $nopol) {
                    if($utility->vehicle_number == $nopol->nopol){
                        $utility->vehicle = $nopol;
                    }
                }
            }
        }
        
        return response($data, 200);
    }


    public function getUndefinedCustomerTransaction(Request $req){
        $budgetMonth = Session::get('sales-month');
        $budgetYear = Session::get('sales-year');

        $budget = SalesBudget::select('customer_sap')
                            ->where('customer_sap','!=',0)
                            ->where('budget','>',0)
                            ->where('sales','!=','NONE')
                            ->whereMonth('period',Session::get('sales-month'))
                            ->whereYear('period',Session::get('sales-year'))
                            ->groupBy('customer_sap')
                            ->get()->pluck('customer_sap');

        $undefinedCustomer = LoadPerformance::selectRaw('customer_reference, customer_name, load_group, COUNT(*) as totalLoads')
                                            ->whereNotIn('customer_reference',$budget)
                                            ->whereIn('load_group',$this->surabayaAllDivision)
                                            ->where('load_status','!=','Voided')
                                            ->whereMonth('created_date',$budgetMonth)
                                            ->whereYear('created_date',$budgetYear)
                                            ->groupBy('customer_reference','customer_name','load_group')
                                            ->get();

        $data['customers'] = [];
        foreach ($undefinedCustomer as $c) {
            $division = "";
            
            //Dividing Group
            if(in_array($c->load_group,$this->transportLoadGroups)){
                $division = "transport";
            }

            if(in_array($c->load_group,$this->eximLoadGroups)){
                $division = "exim";
            }

            if(in_array($c->load_group,$this->bulkLoadGroups)){
                $division = "bulk";
            }

            if(in_array($c->load_group,$this->warehouseLoadGroups)){
                $division = "warehouse";
            }

            //Append Value
            $value = [$c->customer_reference, $c->customer_name, $division, $c->totalLoads, $c->load_group];
            if(!in_array($value, $data['customers']) && $division!=""){
                array_push($data['customers'], $value);
            }
        }
        $data['message'] = "Sukses mengambil data customer";

        return response()->json($data, 200);
    }
}
