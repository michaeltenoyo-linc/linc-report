<?php

namespace App\Http\Controllers\ThirdParty;

use App\Models\LoadPerformance;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;


class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('third-party.pages.landing');
    }

    //Blujay
    public function gotoBlujayMaster(){
        $data['latest'] = LoadPerformance::orderBy('created_at','desc')->first();
        return view('third-party.pages.blujay.blujay-master', $data);
    }

    public function gotoBlujayRefresh(){
        $data['latest'] = LoadPerformance::orderBy('created_at','desc')->first();
        $data['today'] = Carbon::now()->format('Y/m/d');
        //return view('third-party.pages.blujay.gmail-experiment  ', $data);
        return view('third-party.pages.blujay.blujay-refresh', $data);
    }
}