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
}
