<?php

namespace App\Http\Controllers\Greenfields;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\Item;
use App\Models\Suratjalan_greenfields;
use App\Models\Trucks;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //Check log in status
        $this->middleware('auth');
    }

    //Navigation
    public function gotoLandingPage(){
        return view('greenfields.pages.landing');
    }

    public function gotoSoNew(){
        return view('greenfields.pages.nav-so-new');
    }

    public function gotoSoList(){
        return view('greenfields.pages.nav-so-list');
    }

    public function gotoReportGenerate(){
        return view('greenfields.pages.nav-report-generate');
    }

    //DATA CRAWL
    public function getSj(){
        $data = Suratjalan_greenfields::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<form id="btn-sj-delete" class="inline-flex"><input name="no_order" type="hidden" value="'.$row->no_order.'"><input name="no_do" type="hidden" value="'.$row->no_order.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }
}
