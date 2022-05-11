<?php

namespace App\Http\Controllers;

use App\Exports\Statistic_Billable_Blujay;
use App\Exports\Statistic_Routes;
use App\Models\BillableBlujay;
use App\Models\Customer;
use App\Models\LoadPerformance;
use App\Models\ShipmentBlujay;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use Maatwebsite\Excel\Facades\Excel;

class SharedController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateRoutesReport($filterDate){
        if($filterDate == 'ytd'){
            $month = date('m');
            $year = date('Y');

            $routesStatistic = new Collection();
            $customerWithTrans = ShipmentBlujay::select('customer_reference','customer_name')
                                                ->whereYear('load_closed_date',$year)
                                                ->groupBy('customer_reference','customer_name')
                                                ->get();
            
            foreach ($customerWithTrans as $cust) {
                $customerRoutesStatistic = [
                    'Customer SAP' => $cust->customer_reference,
                    'Customer Name' => $cust->customer_name  
                ];

                $loads = ShipmentBlujay::select('load_id')
                                        ->where('customer_reference',$cust->customer_reference)
                                        ->groupBy('load_id')
                                        ->get()->pluck('load_id');


                //FULL YTD
                $routes = LoadPerformance::select('first_pick_location_name','last_drop_location_name')
                                            ->whereYear('closed_date',$year)
                                            ->whereIn('shipper_load_number',$loads)
                                            ->groupBy('first_pick_location_name','last_drop_location_name')
                                            ->get();

                $customerRoutesStatistic['YTD '.$year] = count($routes);

                //MONTH YTD
                for ($i=1; $i <= intval($month); $i++) { 
                    $routes = LoadPerformance::select('first_pick_location_name','last_drop_location_name')
                                            ->whereMonth('closed_date',$i)
                                            ->whereYear('closed_date',$year)
                                            ->whereIn('shipper_load_number',$loads)
                                            ->groupBy('first_pick_location_name','last_drop_location_name')
                                            ->get();

                    $customerRoutesStatistic['Month '.$i] = count($routes);                        
                }

                    
                

                $routesStatistic->push($customerRoutesStatistic);
            }
            
            FacadesSession::put('statistic_routes',$routesStatistic);
            
            return Excel::download(new Statistic_Routes, 'routes_statistic.xlsx');
        }else if('blujay'){
            
        }
    }

    public function generateBillableBlujayReport(){
        //LISTED CUSTOMERS
        $billable = BillableBlujay::select('customer_reference',DB::raw('count(*) as total'))
                                    ->where('expiration_date','>=',Carbon::today()->toDateString())
                                    ->where('effective_date','<=',Carbon::today()->toDateString())
                                    ->where('modifier','LIKE','%LG_DNingrum%')
                                    ->groupBy('customer_reference')
                                    ->get();

        $out1 = new Collection();

        foreach ($billable as $b) {
            $cust = Customer::where('reference','=',$b->customer_reference)->first();

            $out1->push([
                'Reference' => $b->customer_reference,
                'Customer Name' => $b->customer_reference=="UNDEFINED"?"UNDEFINED":$cust->name,
                'Total Data' => $b->total,
            ]);
        }

        //UNDEFINED CUSTOMERS
        $billable_undefined = BillableBlujay::select('billable_tariff',DB::raw('count(*) as total'))
                                            ->where('expiration_date','>=',Carbon::today()->toDateString())
                                            ->where('effective_date','<=',Carbon::today()->toDateString())
                                            ->where('modifier','LIKE','%LG_DNingrum%')
                                            ->where('customer_reference','=','UNDEFINED')
                                            ->groupBy('billable_tariff')
                                            ->get();

        $out2 = new Collection();
        foreach ($billable_undefined as $b) {
            $out2->push([
                'Billable Method' => $b->billable_tariff,
                'Total Data' => $b->total,
            ]);
        }

        FacadesSession::put('statistic_billable_blujay_1',$out1);
        FacadesSession::put('statistic_billable_blujay_2',$out2);
        return Excel::download(new Statistic_Billable_Blujay, 'routes_billable_blujay.xlsx');
    }
}
