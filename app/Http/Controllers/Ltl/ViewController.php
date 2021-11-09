<?php

namespace App\Http\Controllers\Ltl;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;
use App\Models\Suratjalan_ltl;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('ltl.pages.landing');
    }

    public function gotoSoNew(){
        return view('ltl.pages.nav-so-new');
    }

    public function gotoSoList(){
        return view('ltl.pages.nav-so-list');
    }

    public function gotoReportGenerate(){
        return view('ltl.pages.nav-report-generate');
    }

    //DATA CRAWL
    public function getSj(){
        $data = Suratjalan_ltl::get();

        return DataTables::of($data)
            ->addColumn('alamat_full', function($row){
                return $row->lokasi_pengiriman;
            })
            ->addColumn('action', function($row){
                $btn = '<form id="btn-sj-delete" class="inline-flex"><input name="id_so" type="hidden" value="'.$row->id_so.'"><input name="no_do" type="hidden" value="'.$row->no_do.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }
}
