<?php

namespace App\Http\Controllers\LoaOld;

use App\Models\District;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\BillableBlujay;
use App\Models\Customer;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use App\Models\Loa_warehouse;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Trucks;
use App\Models\Village;
use Carbon\Carbon;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('loa.pages.landing');
    }

    public function gotoInputLoa(){
        return view('loa.pages.nav-loa-new');
    }

    public function gotoListLoa(){
        return view('loa.pages.nav-loa-list');
    }

    //New LOA
    public function gotoInputWarehouse(){
        return view('loa.pages.nav-loa-new-warehouse');
    }

    public function gotoInputTransport(){
        return view('loa.pages.nav-loa-new-transport');
    }

    public function gotoInputExim(){
        return view('loa.pages.nav-loa-new-exim');
    }

    //Master Monitor LOA
    public function gotoListWarehouse(){
        $data['warehouse_cust'] = Loa_warehouse::select('customer')->groupBy('customer')->get();

        return view('loa.pages.nav-loa-list-warehouse', $data);
    }

    public function gotoListTransport(){
        $data['transport_cust'] = Loa_transport::select('customer')->groupBy('customer')->get();

        return view('loa.pages.nav-loa-list-transport', $data);
    }

    //Search Engine
    public function gotoSearchTransport(){
        $data['transport_cust'] = Loa_transport::select('customer')->groupBy('customer')->get();
        $data['customer'] = Customer::get();
        $data['units'] = BillableBlujay::select('sku')->groupBy('sku')->get();
        //$data['kel'] = Village::get();
        //$data['kec'] = District::get();
        //$data['kota'] = Regency::get();
        //$data['prov'] = Province::get();

        //return view('loa.pages.nav-loa-search-transport', $data);
        return view('loa.pages.nav-loa-search-billable', $data);
    }

    //Cross Compare
    public function gotoCrossCompare(){
        $data['transport_cust'] = Loa_transport::select('customer')->groupBy('customer')->get();
        $data['units'] = BillableBlujay::select('sku')->groupBy('sku')->get();

        return view('loa.pages.nav-loa-crossfixing', $data);
    }

    //Data Ajax
    public function getWarehouseData(){
        $data = Loa_warehouse::get();

        return DataTables::of($data)
            ->addColumn('no', function($row){
                return " ";
            })
            ->addColumn('periode', function($row){
                $start = Carbon::createFromFormat('Y-m-d',$row->periode_start)->format("d/m/Y");
                $end = Carbon::createFromFormat('Y-m-d',$row->periode_end)->format('d/m/Y');

                return $start." - ".$end;
            })
            ->addColumn('action', function($row){
                if(Carbon::createFromFormat('Y-m-d',$row->periode_end)->isPast()){
                    $btn = '<form id="btn-warehouse-expired" class="inline-flex"><input name="id" type="hidden" value="'.$row->id.'"><button type="submit" class="btn_red">Expired</button></form>';
                    return $btn;
                }else{
                    $open = '<a class="inline-flex" href="'.url('/loa/action/warehouse/detail/'.$row->id).'"><button class="btn_yellow">Open</button></a>';
                    $btn = $open.'<form id="btn-warehouse-delete" class="inline-flex"><input name="id" type="hidden" value="'.$row->id.'"><button type="submit" class="btn_red">Delete</button></form>';
                    return $btn;
                }
                
            })
            ->make(true);
    }

    public function getTransportData(){
        $data = Loa_transport::whereDate('periode_end','>=', Carbon::now())->get();

        return DataTables::of($data)
            ->addColumn('no', function($row){
                return " ";
            })
            ->addColumn('periode', function($row){
                $start = Carbon::createFromFormat('Y-m-d',$row->periode_start)->format("d/m/Y");
                $end = Carbon::createFromFormat('Y-m-d',$row->periode_end)->format('d/m/Y');

                return $start." - ".$end;
            })
            ->addColumn('action', function($row){
                $open = '<a class="inline-flex" href="'.url('/loa/action/transport/detail/'.$row->id).'"><button class="btn_yellow">Open</button></a>';
                $btn = $open.'<form id="btn-transport-delete" class="inline-flex"><input name="id" type="hidden" value="'.$row->id.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }

    public function getLocalData(Request $req, $customer, $route_start, $route_end){
        try {
            $loa = Loa_transport::where('customer',$customer)->whereDate('periode_end','>=', Carbon::now())->first();

            $data['route_start'] = dloa_transport::select('rute_start')->where('id_loa',$loa->id)
                                            ->groupBy('rute_start')
                                            ->get()
                                            ->pluck('rute_start');
            
            $data['route_end'] = $route_start=="all"?"":dloa_transport::select('rute_end')->where('id_loa',$loa->id)
                                            ->where('rute_start',$route_start=="all"?'LIKE':$route_start,$route_start=="all"?'%%':$route_start)
                                            ->groupBy('rute_end')
                                            ->get()
                                            ->pluck('rute_end');

            $data['unit'] = $route_end=="all"?"":dloa_transport::select('unit')->where('id_loa',$loa->id)
                                        ->where('rute_start',$route_start=="all"?'LIKE':$route_start,$route_start=="all"?'%%':$route_start)
                                        ->where('rute_end',$route_end=="all"?'LIKE':$route_end,$route_end=="all"?'%%':$route_end)
                                        ->get()
                                        ->pluck('unit');                                            

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th],404);
        }
        
    }
}
