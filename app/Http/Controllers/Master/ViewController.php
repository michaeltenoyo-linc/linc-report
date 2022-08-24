<?php

namespace App\Http\Controllers\Master;

use App\Http\Middleware\Priviledges;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\Priviledge;
use App\Models\Trucks;
use App\Models\Suratjalan;
use Google\Service\ServiceControl\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Redirect;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        $data['priviledges'] = "NONE";
        

        if(FacadesAuth::user()){
            $priviledge = Priviledge::where('user_id',FacadesAuth::user()->id)->first();
            $data['priviledges'] = explode(';',$priviledge->priviledge);


        }

        return view('master.pages.landing', $data);
    }

    public function notAuthorized(){
        return view('master.pages.not-authorized');
    }

    public function notPriviledges(){
        return view('master.pages.not-priviledges');
    }

    public function underMaintenance(){
        return view('master.pages.under-maintenance');
    }

    public function back(){
        return Redirect::back();
    }
}
