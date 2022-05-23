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
use App\Models\LoadPerformance;
use App\Models\SalesBudget;
use App\Models\ShipmentBlujay;
use App\Models\Suratjalan_greenfields;
use App\Models\Trucks;
use App\Models\unit_surabaya;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;

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
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }else if($ownership == "all"){
            $data['nopol'] = LoadPerformance::select('vehicle_number')
                                            ->whereMonth('created_date',Session::get('sales-month'))
                                            ->whereYear('created_date',Session::get('sales-year'))
                                            ->whereIn('load_group',$divisionGroup)
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }else{
            $data['nopol'] = LoadPerformance::select('vehicle_number')
                                            ->whereMonth('created_date',Session::get('sales-month'))
                                            ->whereYear('created_date',Session::get('sales-year'))
                                            ->whereIn('vehicle_number',$unitSurabaya)
                                            ->whereIn('load_group',$divisionGroup)
                                            ->groupBy('vehicle_number')
                                            ->get()
                                            ->pluck('vehicle_number');
        }

        return response()->json($data,200);
    }

    public function generateTruckingPerformance(Request $req, $ownership, $division, $nopol){
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

        //Ownership Filter
        $unitSurabaya = unit_surabaya::select('nopol')->get()->pluck('nopol');

        if($ownership == "NOT_SBY_OWNED"){
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                    ->whereNotIn('vehicle_number',$unitSurabaya)
                                                    ->where('carrier_name','=','BAHANA PRESTASI')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->groupBy('vehicle_number', 'carrier_name')
                                                    ->whereMonth('created_date',Session::get('sales-month'))
                                                    ->whereYear('created_date',Session::get('sales-year'))
                                                    ->get();
        }else if($ownership == "NOT_SBY_VENDOR"){
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                    ->whereNotIn('vehicle_number',$unitSurabaya)
                                                    ->where('carrier_name','!=','BAHANA PRESTASI')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->groupBy('vehicle_number','carrier_name')
                                                    ->whereMonth('created_date',Session::get('sales-month'))
                                                    ->whereYear('created_date',Session::get('sales-year'))
                                                    ->get();
        }else if($ownership == "all"){
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                    ->whereIn('load_group',$divisionGroup)  
                                                    ->groupBy('vehicle_number','carrier_name')
                                                    ->whereMonth('created_date',Session::get('sales-month'))
                                                    ->whereYear('created_date',Session::get('sales-year'))
                                                    ->get();
        }else{
            $unitSurabaya = unit_surabaya::select('nopol')->where('own',$ownership)->get()->pluck('nopol');
            $data['performance'] = LoadPerformance::selectRaw('vehicle_number, carrier_name, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost, COUNT(tms_id) as totalLoads')
                                                ->whereIn('vehicle_number',$unitSurabaya)
                                                ->whereIn('load_group',$divisionGroup)  
                                                ->groupBy('vehicle_number', 'carrier_name')
                                                ->whereMonth('created_date',Session::get('sales-month'))
                                                ->whereYear('created_date',Session::get('sales-year'))
                                                ->get();
        }

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
        }

        //Period Data
        $data['period'] = Carbon::create()->month(Session::get('sales-month'))->format('F')." ".Session::get('sales-year');
        $data['period_year'] = Session::get('sales-year'); 

        //Sorting
        $data['performance'] = collect($data['performance'])->sortBy('margin_percentage')->reverse();
        return view('sales.pages.pdf.pdf-trucking-performance', $data);
    }

    public function getCustomerData(Request $req, $nopol, $division){
        $data['message'] = "Success";
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

        $loadList = LoadPerformance::select('tms_id')
                                        ->where('vehicle_number',$nopol)
                                        ->whereIn('load_group',$divisionGroup)  
                                        ->whereMonth('created_date',Session::get('sales-month'))
                                        ->whereYear('created_date',Session::get('sales-year'))
                                        ->get()->pluck('tms_id');

        $data['customers'] = ShipmentBlujay::selectRaw('customer_reference, customer_name')
                                        ->whereIn('load_id',$loadList)
                                        ->groupBy('customer_reference','customer_name')
                                        ->get();

        foreach ($data['customers'] as $row) {
            $customerLoadList = ShipmentBlujay::select('load_id')
                                                ->where('customer_reference',$row->customer_reference)
                                                ->where('customer_name',$row->customer_name)
                                                ->whereIn('load_id',$loadList)
                                                ->get()->pluck('load_id');
            
            $customerRates = LoadPerformance::select('tms_id','billable_total_rate','payable_total_rate')
                                        ->whereIn('tms_id',$customerLoadList)  
                                        ->get();

            $routeRates = LoadPerformance::selectRaw("first_pick_location_city, last_drop_location_city, CONCAT(REPLACE(first_pick_location_city,' ',''),'-',REPLACE(last_drop_location_city,' ','')) as route_id, CONCAT(first_pick_location_city,' - ',last_drop_location_city) as route, SUM(billable_total_rate) as totalRevenue, SUM(payable_total_rate) as totalCost")
                                            ->whereIn('tms_id',$customerLoadList)  
                                            ->groupBy('route_id', 'route', 'first_pick_location_city', 'last_drop_location_city')
                                            ->get();
            
            $totalBillable = 0;
            $totalPayable = 0;

            foreach ($customerRates as $rate) {
                $totalBillable += $rate->billable_total_rate;
                $totalPayable += $rate->payable_total_rate;
            }

            //Routes to Load
            foreach ($routeRates as $rate) {
                $rate->route_id = $row->customer_reference."-".$rate->route_id;
                $rate->loadList = LoadPerformance::selectRaw('tms_id, billable_total_rate, payable_total_rate, (billable_total_rate - payable_total_rate) as net')
                                                        ->whereIn('tms_id',$customerLoadList)  
                                                        ->where('first_pick_location_city', $rate->first_pick_location_city)
                                                        ->where('last_drop_location_city', $rate->last_drop_location_city)
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
}
