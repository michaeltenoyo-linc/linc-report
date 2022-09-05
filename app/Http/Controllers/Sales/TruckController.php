<?php

namespace App\Http\Controllers\Sales;

use App\Exports\Sales_ReportCustomerPerformance;
use App\Exports\Sales_ReportTruckingPerformance;
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
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PDO;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

use function PHPSTORM_META\map;
use function PHPUnit\Framework\isNan;
use function PHPUnit\Framework\isNull;

class TruckController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //Blujay Load Group (Exim, Bulk, Transport)
    private $transportLoadGroups = ['SURABAYA LOG PACK', 'SURABAYA RENTAL', 'SURABAYA RENTAL TRIP', 'SURABAYA TIV LOKAL'];
    private $eximLoadGroups = ['SURABAYA EXIM TRUCKING', 'SURABAYA TIV IMPORT'];
    private $bulkLoadGroups = ['SURABAYA LOG BULK'];
    private $warehouseLoadGroups = [];
    private $emptyLoadGroups = ['SURABAYA MOB KOSONGAN'];
    private $surabayaLoadGroups = ['SURABAYA LOG PACK', 'SURABAYA RENTAL', 'SURABAYA RENTAL TRIP', 'SURABAYA TIV LOKAL','SURABAYA EXIM TRUCKING', 'SURABAYA TIV IMPORT','SURABAYA LOG BULK','SURABAYA MOB KOSONGAN'];
    private $billableThreshold = 100;

    public function getFilteringTruck(Request $req, $division, $ownership){
        //Division Change
        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'surabaya':
                $division = 'Surabaya';
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }
        
        $unitSurabaya = unit_surabaya::select('nopol')->where('own',$ownership)->get()->pluck('nopol');

        if($ownership == "NOT_SBY_OWNED"){
            $unitSurabaya = unit_surabaya::select('nopol')->get()->pluck('nopol');
            $data['nopol'] = LoadPerformance::select('vehicle_number')
                                            ->whereMonth('created_date',Session::get('sales-month'))
                                            ->whereYear('created_date',Session::get('sales-year'))
                                            ->whereNotIn('vehicle_number',$unitSurabaya)
                                            ->where('carrier_name','=','BAHANA PRESTASI')
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->whereIn('load_group',$divisionGroup)  
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }else if($ownership == "NOT_SBY_VENDOR"){
            $unitSurabaya = unit_surabaya::select('nopol')->get()->pluck('nopol');
            $data['nopol'] = LoadPerformance::select('vehicle_number')
                                            ->whereMonth('created_date',Session::get('sales-month'))
                                            ->whereYear('created_date',Session::get('sales-year'))
                                            ->whereNotIn('vehicle_number',$unitSurabaya)
                                            ->where('carrier_name','!=','BAHANA PRESTASI')
                                            ->whereIn('load_group',$divisionGroup)
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }else if($ownership == "all"){
            $data['nopol'] = LoadPerformance::select('vehicle_number')
                                            ->whereMonth('created_date',Session::get('sales-month'))
                                            ->whereYear('created_date',Session::get('sales-year'))
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->whereIn('load_group',$divisionGroup)
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }else{
            $data['nopol'] = LoadPerformance::select('vehicle_number')
                                            ->whereMonth('created_date',Session::get('sales-month'))
                                            ->whereYear('created_date',Session::get('sales-year'))
                                            ->whereIn('vehicle_number',$unitSurabaya)
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->whereIn('load_group',$divisionGroup)
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }

        return response()->json($data,200);
    }

    public function generateTruckingPerformanceData($ownership, $division, $nopol, $dateConstraint, $status){
        Session::put('sales-constraint',$dateConstraint);
        $data['division'] = $division;
        //Division Change
        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'surabaya':
                $division = 'Surabaya';
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }

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

        //Ownership Filter
        $unitSurabaya = unit_surabaya::select('nopol')->get()->pluck('nopol');

        if($ownership == "NOT_SBY_OWNED"){
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                    ->whereNotIn('vehicle_number',$unitSurabaya)
                                                    ->where('carrier_name','=','BAHANA PRESTASI')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->where('billable_total_rate','>',$this->billableThreshold)
                                                    ->where('load_status','!=','Voided')
                                                    ->where($statusCondition)
                                                    ->groupBy('vehicle_number', 'carrier_name')
                                                    ->whereNotNull($dateConstraint)
                                                    ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                    ->get();
        }else if($ownership == "NOT_SBY_VENDOR"){
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                    ->whereNotIn('vehicle_number',$unitSurabaya)
                                                    ->where('carrier_name','!=','BAHANA PRESTASI')
                                                    ->where('billable_total_rate','>',$this->billableThreshold)
                                                    ->where('load_status','!=','Voided')
                                                    ->where($statusCondition)
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->groupBy('vehicle_number','carrier_name')
                                                    ->whereNotNull($dateConstraint)
                                                    ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                    ->get();
        }else if($ownership == "all"){
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->where('billable_total_rate','>',$this->billableThreshold)
                                                    ->groupBy('vehicle_number','carrier_name')
                                                    ->where('load_status','!=','Voided')
                                                    ->where($statusCondition)
                                                    ->whereNotNull($dateConstraint)
                                                    ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                    ->get();
        }else{
            $unitSurabaya = unit_surabaya::select('nopol')->where('own',$ownership)->get()->pluck('nopol');
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                ->whereIn('vehicle_number',$unitSurabaya)
                                                ->where('billable_total_rate','>',$this->billableThreshold)
                                                ->whereIn('load_group',$divisionGroup)  
                                                ->groupBy('vehicle_number', 'carrier_name')
                                                ->where('load_status','!=','Voided')
                                                ->where($statusCondition)
                                                ->whereNotNull($dateConstraint)
                                                ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                ->get();
        }

        $data['overall_revenue'] = 0;
        $data['overall_cost'] = 0;
        $data['countAll'] = 0;
        foreach ($data['performance'] as $row) {
            $unitDetail = unit_surabaya::where('nopol',$row->vehicle_number)->first();
            //unit detail
            if($unitDetail != null){
                $row->carrier_name = $unitDetail->own;
                $row->unit_type = $unitDetail->type;
                $row->current_driver = $unitDetail->driver;
            }else{
                $row->unit_type = "Unknown - Unit Luar Surabaya";
                $row->current_driver = "Unknown - Unit Luar Surabaya";
            }

            //margin percentage
            $row->revenue_format = number_format($row->totalRevenue,0,',','.');
            $row->cost_format = number_format($row->totalCost,0,',','.');
            $row->net = $row->totalRevenue - $row->totalCost;
            $row->net_format = number_format($row->net,0,',','.');
            if($row->totalRevenue == 0)
                $row->totalRevenue = 1;
            

            if($row->net > 0){
                $row->margin_percentage = floatval($row->net)/floatval($row->totalRevenue) * 100;
                $row->margin_percentage = round(floatval($row->margin_percentage), 2);
                $row->mYay = $row->margin_percentage;
                $row->mNay = 0;
            }else if($row->net < 0){
                $row->margin_percentage = floatval($row->net)/floatval($row->totalRevenue) * 100;
                $row->margin_percentage = round(floatval($row->margin_percentage), 2);
                $row->mYay = 0;
                $row->mNay = $row->margin_percentage*-1;
            }else{
                $row->mYay = 0;
                $row->mNay = 0;
            }

            $data['overall_revenue'] += $row->totalRevenue;
            $data['overall_cost'] += $row->totalCost;

            
            $data['countAll'] += $row->totalLoads;
        }
        //Period Data
        $data['period_from'] = Session::get('sales-from')->format('d M Y');
        $data['period_to'] = Session::get('sales-to')->format('d M Y');
        $data['period_constraint'] = $dateConstraint;

        //Sorting
        $data['performance'] = collect($data['performance'])->sortBy('totalRevenue')->reverse();

        return $data;
    }

    public function generateTruckingPerformance(Request $req, $ownership, $division, $nopol, $dateConstraint, $status){
        return view('sales.pages.pdf.pdf-trucking-performance', $this->generateTruckingPerformanceData($ownership, $division, $nopol, $dateConstraint, $status));
    }

    public function downloadTruckingPerformance(Request $req, $ownership, $division, $nopol, $dateConstraint, $status){
        $data = $this->generateTruckingPerformanceData($ownership, $division, $nopol, $dateConstraint, $status);
        $reports = new Collection;
        $ctr = 1;

        foreach ($data['performance'] as $row) {
            $reports->push([
                'No' => $ctr,
                'Nopol' => $row->vehicle_number,
                'Carrier' => $row->carrier_name,
                'Unit' => $row->unit_type,
                'Driver' => $row->current_driver,
                'Total Loads' => $row->totalLoads,
                'Billable' => $row->totalRevenue,
                'Payable' => $row->totalCost,
                'Profit' => $row->totalRevenue-$row->totalCost,
                'Margin' =>  $row->margin_percentage/100,
            ]);

            $reports->push([
                'No' => '',
                'Nopol' => '',
                'Carrier' => '',
                'Unit' => '',
                'Driver' => '',
                'Total Loads' => '',
                'Billable' => '',
                'Payable' => '',
                'Profit' => '',
                'Margin' =>  ''
            ]);
            $ctr++;
        }

        Session::put('totalReport', $ctr-1);
        Session::put('resultReport', $reports);

        return Excel::download(new Sales_ReportTruckingPerformance, 'trucking performance.xlsx');
    }

    public function generateCustomerPerformanceData($ownership, $division, $nopol, $dateConstraint, $status){
        Session::put('sales-constraint',$dateConstraint);
        $data['division'] = $division;
        //Division Change
        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'surabaya':
                $division = 'Surabaya';
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }

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

        //Ownership Filter
        $unitSurabaya = unit_surabaya::select('nopol')->get()->pluck('nopol');

        if($ownership == "NOT_SBY_OWNED"){
            $performanceList = LoadPerformance::selectRaw('tms_id')
                                                    ->whereNotIn('vehicle_number',$unitSurabaya)
                                                    ->where('carrier_name','=','BAHANA PRESTASI')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->where('billable_total_rate','>',$this->billableThreshold)
                                                    ->where('load_status','!=','Voided')
                                                    ->where($statusCondition)
                                                    ->whereNotNull($dateConstraint)
                                                    ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                    ->get()->pluck('tms_id');
        }else if($ownership == "NOT_SBY_VENDOR"){
            $performanceList = LoadPerformance::selectRaw('tms_id')
                                                    ->whereNotIn('vehicle_number',$unitSurabaya)
                                                    ->where('carrier_name','!=','BAHANA PRESTASI')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->where('load_status','!=','Voided')
                                                    ->where($statusCondition)
                                                    ->where('billable_total_rate','>',$this->billableThreshold)
                                                    ->whereNotNull($dateConstraint)
                                                    ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                    ->get()->pluck('tms_id');
        }else if($ownership == "all"){
            $performanceList = LoadPerformance::selectRaw('tms_id')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->where('billable_total_rate','>',$this->billableThreshold)
                                                    ->where('load_status','!=','Voided')
                                                    ->where($statusCondition)
                                                    ->whereNotNull($dateConstraint)
                                                    ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                    ->get()->pluck('tms_id');
        }else{
            $unitSurabaya = unit_surabaya::select('nopol')->where('own',$ownership)->get()->pluck('nopol');
            $performanceList = LoadPerformance::selectRaw('tms_id')
                                                ->whereIn('vehicle_number',$unitSurabaya)
                                                ->where('billable_total_rate','>',$this->billableThreshold)
                                                ->whereIn('load_group',$divisionGroup)  
                                                ->where('load_status','!=','Voided')
                                                ->where($statusCondition)
                                                ->whereNotNull($dateConstraint)
                                                ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                                ->get()->pluck('tms_id');
        }
        $data['performance'] = $performanceList;
        //Customer List
        $data['customer'] = LoadPerformance::selectRaw('customer_reference, customer_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                            ->whereIntegerInRaw('tms_id',$performanceList)
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->groupBy('customer_reference','customer_name')
                                            ->where('load_status','!=','Voided')
                                            ->where($statusCondition)
                                            ->get();
        $data['overall_revenue'] = 0;
        $data['overall_cost'] = 0;

        //Customer Detail
        foreach ($data['customer'] as $row) {
            //margin percentage
            $row->revenue_format = number_format($row->totalRevenue,0,',','.');
            $row->cost_format = number_format($row->totalCost,0,',','.');
            $row->net = $row->totalRevenue - $row->totalCost;
            $row->net_format = number_format($row->net,0,',','.');
            if($row->totalRevenue == 0)
                $row->totalRevenue = 1;
            

            if($row->net > 0){
                $row->margin_percentage = floatval($row->net)/floatval($row->totalRevenue) * 100;
                $row->margin_percentage = round(floatval($row->margin_percentage), 2);
                $row->mYay = $row->margin_percentage;
                $row->mNay = 0;
            }else if($row->net < 0){
                $row->margin_percentage = floatval($row->net)/floatval($row->totalRevenue) * 100;
                $row->margin_percentage = round(floatval($row->margin_percentage), 2);
                $row->mYay = 0;
                $row->mNay = $row->margin_percentage*-1;
            }else{
                $row->mYay = 0;
                $row->mNay = 0;
            }

            $data['overall_revenue'] += $row->totalRevenue;
            $data['overall_cost'] += $row->totalCost;
        }

        //Period Data
        $data['period_from'] = Session::get('sales-from')->format('d M Y');
        $data['period_to'] = Session::get('sales-to')->format('d M Y');
        $data['period_constraint'] = $dateConstraint;

        //Sorting
        $data['customer'] = collect($data['customer'])->sortBy('totalRevenue')->reverse();
        
        return $data;
    }

    public function generateCustomerPerformance(Request $req, $ownership, $division, $nopol, $dateConstraint, $status){
        return view('sales.pages.pdf.pdf-customer-trucking-performance', $this->generateCustomerPerformanceData($ownership, $division, $nopol, $dateConstraint, $status));
    }

    public function downloadCustomerPerformance(Request $req, $ownership, $division, $nopol, $dateConstraint, $status){
        $data = $this->generateCustomerPerformanceData($ownership, $division, $nopol, $dateConstraint, $status);
        $reports = new Collection;
        $ctr = 1;

        foreach ($data['customer'] as $row) {
            $reports->push([
                'No' => $ctr,
                'Customer Reference' => $row->customer_reference,
                'Customer Name' => $row->customer_name,
                'Total Loads' => $row->totalLoads,
                'Billable' => $row->totalRevenue,
                'Payable' => $row->totalCost,
                'Profit' => $row->totalRevenue-$row->totalCost,
                'Margin' =>  $row->margin_percentage/100,
            ]);

            $reports->push([
                'No' => '',
                'Customer Reference' => '',
                'Customer Name' => '',
                'Total Loads' => '',
                'Billable' => '',
                'Payable' => '',
                'Profit' => '',
                'Margin' =>  ''
            ]);

            $ctr++;
        }

        Session::put('totalReport', $ctr-1);
        Session::put('resultReport', $reports);

        return Excel::download(new Sales_ReportCustomerPerformance, 'customer performance.xlsx');           
    }

    public function getCustomerData(Request $req, $nopol, $division){
        $data['message'] = "Success";
        $data['division'] = $division;
        $dateConstraint = Session::get('sales-constraint');
        //Division Change
        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'surabaya':
                $division = 'Surabaya';
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }

        //status constraint
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


        $loadList = LoadPerformance::select('tms_id')
                                        ->where('vehicle_number',$nopol)
                                        ->where('billable_total_rate','>',$this->billableThreshold)
                                        ->whereIn('load_group',$divisionGroup)  
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->whereNotNull($dateConstraint)
                                        ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                        ->get()->pluck('tms_id');

        $data['customers'] = LoadPerformance::selectRaw('customer_reference, customer_name')
                                        ->whereIn('tms_id',$loadList)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->groupBy('customer_reference','customer_name')
                                        ->get();
                                        
        foreach ($data['customers'] as $row) {
            $customerLoadList = LoadPerformance::select('tms_id')
                                                ->where('customer_reference',$row->customer_reference)
                                                ->where('customer_name',$row->customer_name)
                                                ->whereIn('tms_id',$loadList)
                                                ->where('load_status','!=','Voided')
                                                ->where($statusCondition)
                                                ->get()->pluck('tms_id');
            
            $customerRates = LoadPerformance::select('tms_id','billable_total_rate','payable_total_rate')
                                        ->where('billable_total_rate','>',$this->billableThreshold)
                                        ->whereIn('tms_id',$customerLoadList) 
                                        ->where('load_status','!=','Voided') 
                                        ->where($statusCondition)
                                        ->get();

            $routeRates = LoadPerformance::selectRaw("REPLACE(routing_guide_name,' ','') as route_id, 
                                                        routing_guide_name as route, 
                                                        SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost")
                                            ->whereIn('tms_id',$customerLoadList)  
                                            ->where('load_status','!=','Voided')
                                            ->where($statusCondition)
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->groupBy('route_id', 'route')
                                            ->get();
            
            $totalBillable = 0;
            $totalPayable = 0;

            foreach ($customerRates as $rate) {
                $totalBillable += $rate->billable_total_rate;
                $totalPayable += $rate->payable_total_rate;
            }

            //Routes to Load
            foreach ($routeRates as $rate) {
                $rate->route_id = str_replace(array('(',')'),'',$row->customer_reference."-".$rate->route_id);
                $rate->loadList = LoadPerformance::selectRaw('tms_id, billable_total_rate, payable_total_rate, (billable_total_rate - payable_total_rate) as net')
                                                        ->whereIn('tms_id',$customerLoadList)  
                                                        ->where('billable_total_rate','>',$this->billableThreshold)
                                                        ->where('routing_guide_name', $rate->route)
                                                        ->where('load_status','!=','Voided')
                                                        ->where($statusCondition)
                                                        ->get();
            }

            $row->routes = $routeRates;
            $row->loads = $customerLoadList;
            $row->count = count($customerLoadList);
            $row->totalRevenue = $totalBillable;
            $row->totalCost = $totalPayable;
            $row->totalRevenueFormat = number_format($totalBillable,0,',','.');
            $row->totalCostFormat = number_format($totalPayable,0,',','.');
            $row->rates = $customerRates;
            $row->net = $totalBillable - $totalPayable;
            $row->netFormat = number_format($row->net,0,',','.');
        }

        return response()->json($data, 200);
    }

    public function getUnitData(Request $req, $reference, $division){
        $data['message'] = "Success";
        $data['division'] = $division;
        $dateConstraint = Session::get('sales-constraint');
        
        //Division Change
        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'surabaya':
                $division = 'Surabaya';
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }

        //status constraint
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

        $loadList = LoadPerformance::select('tms_id')
                                        ->where('customer_reference',$reference)
                                        ->where('billable_total_rate','>',$this->billableThreshold)
                                        ->whereIn('load_group',$divisionGroup)  
                                        ->whereNotNull($dateConstraint)
                                        ->whereBetween($dateConstraint,[Session::get('sales-from'),Session::get('sales-to')])
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->get()->pluck('tms_id');
        $data['loads'] = $loadList;
        $data['units'] = LoadPerformance::selectRaw('vehicle_number, carrier_name')
                                        ->whereIn('tms_id',$loadList)
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->groupBy('vehicle_number','carrier_name')
                                        ->get();

        foreach ($data['units'] as $row) {
            $unitLoadList = LoadPerformance::select('tms_id')
                                                ->where('vehicle_number',$row->vehicle_number)
                                                ->whereIn('tms_id',$loadList)
                                                ->where('load_status','!=','Voided')
                                                ->where($statusCondition)
                                                ->get()->pluck('tms_id');
            
            $unitRates = LoadPerformance::select('tms_id','billable_total_rate','payable_total_rate')
                                        ->where('billable_total_rate','>',$this->billableThreshold)
                                        ->whereIn('tms_id',$unitLoadList)  
                                        ->where('load_status','!=','Voided')
                                        ->where($statusCondition)
                                        ->get();

            $routeRates = LoadPerformance::selectRaw("REPLACE(routing_guide_name,' ','') as route_id, 
                                                routing_guide_name as route, 
                                                SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost")->whereIn('tms_id',$unitLoadList)  
                                            ->where('billable_total_rate','>',$this->billableThreshold)
                                            ->where('load_status','!=','Voided')
                                            ->where($statusCondition)
                                            ->groupBy('route_id', 'route')
                                            ->get();
            
            $totalBillable = 0;
            $totalPayable = 0;

            foreach ($unitRates as $rate) {
                $totalBillable += $rate->billable_total_rate;
                $totalPayable += $rate->payable_total_rate;
            }

            //Routes to Load
            foreach ($routeRates as $rate) {
                if($row->vehicle_number==" "){
                    $row->vehicle_number="XXXXXX";
                }
                $rate->route_id = str_replace(array('(',')'),'',$row->vehicle_number."-".$rate->route_id);
                $rate->loadList = LoadPerformance::selectRaw('tms_id, billable_total_rate, payable_total_rate, (billable_total_rate - payable_total_rate) as net')
                                                        ->whereIn('tms_id',$unitLoadList)  
                                                        ->where('billable_total_rate','>',$this->billableThreshold)
                                                        ->where('load_status','!=','Voided')
                                                        ->where($statusCondition)
                                                        ->where('routing_guide_name', $rate->route)
                                                        ->get();
            }

            $row->routes = $routeRates;
            $row->loads = $unitLoadList;
            $row->count = count($unitLoadList);
            $row->totalRevenue = $totalBillable;
            $row->totalCost = $totalPayable;
            $row->totalRevenueFormat = number_format($totalBillable,0,',','.');
            $row->totalCostFormat = number_format($totalPayable,0,',','.');
            $row->rates = $unitRates;
            $row->net = $totalBillable - $totalPayable;
            $row->netFormat = number_format($row->net,0,',','.');
        }

        return response()->json($data, 200);
    }

    public function getYearlyAchievement(Request $req, $id, $division){
        /* JIKA BUDGET TRUCK SUDAH ADA

        $tempBudget = TruckBudget::find($id);

        $data['message'] = "Sukses mengambil data budget.";
        $data['yearly_budget'] = SalesBudget::where('customer_name',$tempBudget->customer_name)
                                        ->where('division',$tempBudget->division)
                                        ->whereYear('period',Session::get('sales-year'))
                                        ->orderBy('period','asc')
                                        ->get()
                                        ->pluck('budget');

        */
        $data['yearly_budget'] = [0,0,0,0,0,0,0,0,0,0,0,0];

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

        //Division
        $divisionGroup = [];
        switch ($division) {
            case 'transport':
                $division = 'Pack Trans';
                $divisionGroup = $this->transportLoadGroups;
                break;
            case 'exim':
                $division = 'Freight Forwarding BP';
                $divisionGroup = $this->eximLoadGroups;
                break;
            case 'bulk':
                $division = 'Bulk Trans';
                $divisionGroup = $this->bulkLoadGroups;
                break;
            case 'surabaya':
                $division = 'Surabaya';
                $divisionGroup = $this->surabayaLoadGroups;
            default:
                break;
        }

        $data['yearly_revenue'] = [];

        //Blujay
        $dbYearlyRevenue = LoadPerformance::selectRaw("
                                        SUM(billable_total_rate) as totalActual,
                                        DATE_FORMAT(".$dateConstraint.",'%m') as monthKey
                                    ")
                                    ->where('vehicle_number',$id)
                                    ->whereIn('load_group',$divisionGroup)
                                    ->where('billable_total_rate','>',$this->billableThreshold)
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

    public function getLeadTime(Request $req){
        $leadTime = lead_time::get();

        return DataTables::of($leadTime)->make(true);
    }

    public function generateTruckingUtility(Request $req, $ownership){
        $month = Session::get('sales-month');
        $year = Session::get('sales-year');
        $totalDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $defaultActivity = array_fill(0,$totalDays,"idle");

        //Truck List
        $truck = [];
        if($ownership == "all"){
            $truck = unit_surabaya::get();
        }else{
            $truck = unit_surabaya::where('own',$ownership)->get();
        }

        //Fill Truck Activity
        $overallIdlePercentage = 0;
        $overallOnCallPercentage = 0;
        $overallIdle = 0;
        $overallOnCall = 0;

        foreach ($truck as $row) {
            $activity = $defaultActivity;

            $loadList = LoadPerformance::select('tms_id','created_date','first_pick_location_city','last_drop_location_city')
                                        ->where('vehicle_number',$row->nopol)
                                        ->whereMonth('created_date',$month)
                                        ->whereYear('created_date',$year)
                                        ->orderBy('created_date','asc')
                                        ->get();
                                        
            foreach ($loadList as $load) {
                //Lead Time
                $leadTime = lead_time::select('ltpod')
                                    ->where('rg_origin','LIKE','%'.$load->first_pick_location_city.'%')
                                    ->where('rg_destination','LIKE','%'.$load->last_drop_location_city.'%')
                                    ->orderBy('ltpod','asc')
                                    ->first();
                if($leadTime == null){
                    $load->lead_time = 1;
                }else{
                    $load->lead_time = $leadTime->ltpod;
                }

                //Add To Activity Array
                $dateNumber = Carbon::parse($load->created_date)->format('d');
                for ($i=$dateNumber-1; $i < $dateNumber+$load->lead_time-1; $i++) { 
                    if($i < count($activity)){
                        $activity[$i] = "On Call - ".$load->tms_id;
                    }
                }
            }

            //Activity Overview
            $countIdle = 0;
            $countOnCall = 0;
            foreach ($activity as $act) {
                if($act == "idle"){
                    $countIdle++;
                }else{
                    $countOnCall++;
                }
            }

            $row->count_idle = $countIdle;
            $row->count_on_call = $countOnCall;    
            $row->idle_percentage = floatval($row->count_idle)/floatval($totalDays) * 100;
            $row->idle_percentage = round(floatval($row->idle_percentage), 2);
            $row->on_call_percentage = floatval($row->count_on_call)/floatval($totalDays) * 100;
            $row->on_call_percentage = round(floatval($row->on_call_percentage), 2);   
            $row->activity = $activity;
            $row->loads = $loadList;
            $row->countLoad = count($loadList);

            //Overall Add
            $overallIdle += $row->count_idle;
            $overallIdlePercentage += $row->idle_percentage;
            $overallOnCall += $row->count_on_call;
            $overallOnCallPercentage += $row->on_call_percentage;
        }

        $truck = collect($truck)->sortBy('on_call_percentage')->reverse();

        //Overview Overall
        $data['avg_idle'] = round($overallIdle/count($truck), 2);
        $data['avg_idle_percentage'] = round($overallIdlePercentage/count($truck), 2);
        $data['avg_on_call'] = round($overallOnCall/count($truck), 2);
        $data['avg_on_call_percentage'] = round($overallOnCallPercentage/count($truck), 2);

        //Data Finalization
        $data['year'] = $year;
        $data['month'] = $month;
        $data['ownership'] = $ownership;
        $data['unit'] = $truck;

        //Period Data
        $data['period'] = Carbon::create()->month(Session::get('sales-month'))->format('F')." ".Session::get('sales-year');
        $data['period_year'] = Session::get('sales-year');
        $data['today_date'] = Carbon::now()->format('d');
        $data['today_full_date'] = Carbon::now()->format('d M Y');

        return view('sales.pages.pdf.pdf-trucking-utility', $data);
        //return $data;
    }

    public function getTruckCalendar(Request $req, $nopol){
        $month = Session::get('sales-month');
        $year = Session::get('sales-year');
        $totalDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $defaultActivity = array_fill(0,$totalDays,"idle");
        $defaultDayName = [];

        for ($i=1; $i <= $totalDays; $i++) { 
            $today = Carbon::createFromFormat('d/m/Y',  $i.'/'.$month.'/'.$year)->format('l');
            array_push($defaultDayName, $today);
        }

        //Truck
        $truck = unit_surabaya::find($nopol);

        //Fill Truck Activity
        $activity = $defaultActivity;
        $loadList = LoadPerformance::select('tms_id','created_date','first_pick_location_city','last_drop_location_city')
                                    ->where('vehicle_number',$truck->nopol)
                                    ->whereMonth('created_date',$month)
                                    ->whereYear('created_date',$year)
                                    ->orderBy('created_date','asc')
                                    ->get();

        foreach ($loadList as $load) {
            //Lead Time
            $leadTime = lead_time::select('ltpod')
                                ->where('rg_origin','LIKE','%'.$load->first_pick_location_city.'%')
                                ->where('rg_destination','LIKE','%'.$load->last_drop_location_city.'%')
                                ->orderBy('ltpod','asc')
                                ->first();
            if($leadTime == null){
                $load->lead_time = 1;
            }else{
                $load->lead_time = $leadTime->ltpod;
            }

            //Add To Activity Array
            $dateNumber = Carbon::parse($load->created_date)->format('d');
            for ($i=$dateNumber-1; $i < $dateNumber+$load->lead_time-1; $i++) { 
                if($i < count($activity)){
                    $activity[$i] = $load->tms_id;
                }
            }
        }
        $truck->activity = $activity;
        $truck->loads = $loadList;
        $truck->dayName = $defaultDayName;

        //Data Finalization
        $data['year'] = $year;
        $data['month'] = $month;
        $data['unit'] = $truck;

        //Period Data
        $data['period'] = Carbon::create()->month(Session::get('sales-month'))->format('F')." ".Session::get('sales-year');
        $data['period_year'] = Session::get('sales-year');

        return response()->json($data, 200);
    }
}
