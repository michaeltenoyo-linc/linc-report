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
use App\Models\CustomerLtl;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('ltl.pages.landing');
    }

    public function gotoSoNew(){
        $data['customers'] = CustomerLtl::get();
        $data['customers_hist'] = Suratjalan_ltl::select('customer_name')->groupBy('customer_name')->get();
        $data['location_hist'] = Suratjalan_ltl::select('lokasi_pengiriman')->groupBy('lokasi_pengiriman')->get();
        return view('ltl.pages.nav-so-new', $data);
    }

    public function gotoSoList(){
        return view('ltl.pages.nav-so-list');
    }

    public function gotoReportGenerate(){
        return view('ltl.pages.nav-report-generate');
    }

    //DATA CRAWL
    public function getSjById($id){
        $sj = Suratjalan_ltl::where('id_so','=',$id)->first();

        $out = [
            'sj' => $sj,
        ];

        return response()->json(['data' => $out], 200);
    }

    public function getSj(){
        $data = Suratjalan_ltl::get();

        return DataTables::of($data)
            ->addColumn('alamat_full', function($row){
                return $row->lokasi_pengiriman;
            })
            ->addColumn('created_at_format', function($row){
                return date('Y-m-d H:i:s', strtotime($row->created_at));
            })
            ->addColumn('action', function($row){
                $btn = '<button id="btn-sj-edit" type="button" value="'.$row->id_so.'" class="btn_yellow">Edit</button>';
                $btn = $btn.'<form id="btn-sj-delete" class="inline-flex"><input name="id_so" type="hidden" value="'.$row->id_so.'"><input name="no_do" type="hidden" value="'.$row->no_do.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }
}
