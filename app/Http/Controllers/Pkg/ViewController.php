<?php

namespace App\Http\Controllers\Pkg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('pkg.pages.landing');
    }

    public function gotoSoNew(){
        return view('pkg.pages.nav-so-new');
    }

    public function gotoSoList(){
        return view('pkg.pages.nav-so-list');
    }

    public function gotoGenerateReport(){
        return view('pkg.pages.nav-report-generate');
    }
}
