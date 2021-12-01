<?php

namespace App\Http\Controllers\Loa;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\Loa_warehouse;
use App\Models\Trucks;
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

    //Master Monitor LOA
    public function gotoListWarehouse(){
        $data['warehouse_cust'] = Loa_warehouse::select('customer')->groupBy('customer')->get();

        return view('loa.pages.nav-loa-list-warehouse', $data);
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
                $open = '<a class="inline-flex" href="'.url('/loa/action/warehouse/detail/'.$row->id).'"><button class="btn_yellow">Open</button></a>';
                $btn = $open.'<form id="btn-warehouse-delete" class="inline-flex"><input name="id" type="hidden" value="'.$row->id.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }
}
