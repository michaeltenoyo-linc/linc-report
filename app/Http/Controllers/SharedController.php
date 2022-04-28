<?php

namespace App\Http\Controllers;

use App\Exports\Statistic_Routes;
use App\Models\LoadPerformance;
use App\Models\ShipmentBlujay;
use Illuminate\Support\Collection;
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
}
