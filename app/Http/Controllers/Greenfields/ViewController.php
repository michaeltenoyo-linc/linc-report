<?php

namespace App\Http\Controllers\Greenfields;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\Trucks;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
}
