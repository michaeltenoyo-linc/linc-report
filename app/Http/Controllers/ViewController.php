<?php

namespace App\Http\Controllers;

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

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage(){
        return view('pages.landing');
    }

    public function gotoItemNew(){
        return view('pages.nav-items-new');
    }

    public function gotoItemList(){
        return view('pages.nav-items-list');
    }

    public function gotoTrucksList(){
        return view('pages.nav-trucks-list');
    }

    public function gotoTrucksNew(){
        return view('pages.nav-trucks-new');
    }

    public function gotoSoList(){
        return view('pages.nav-so-list');
    }

    public function gotoSoNew(){
        return view('pages.nav-so-new');
    }

    public function gotoReportGenerate(){
        return view('pages.nav-report-generate');
    }

    //DATA CRAWL
    public function getSj(){
        $data = Suratjalan::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<form id="btn-sj-delete" class="inline-flex"><input name="id_so" type="hidden" value="'.$row->id_so.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }

    public function getItems(){
        $data = Item::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<a href="items/'.$row->material_code.'" class="btn_yellow">Edit</a>';
                $btn = '<form id="btn-items-delete" class="inline-flex"><input name="materialCode" type="hidden" value="'.$row->material_Code.'">'.$btn.'<button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);

    }

    public function getTrucks(){
        $data = Trucks::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<a href="trucks/'.$row->nopol.'" class="btn_yellow">Edit</a>';
                $btn = '<form id="btn-trucks-delete" class="inline-flex"><input name="materialCode" type="hidden" value="'.$row->material_Code.'">'.$btn.'<button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }

    public function search_getTrucks(Request $req){
        $query = $req->get('query');
        $filterResult = Trucks::select('nopol')->where('nopol','LIKE','%'.$query.'%')->pluck('nopol');

        return response()->json($filterResult);
    }

    public function search_getItems(Request $req){
        $query = $req->get('query');
        $filterResult = Item::select('material_code')->where('material_code','LIKE','%'.$query.'%')->pluck('material_code');
    
        return response()->json($filterResult);
    }

    public function getItemsFromid(Request $req){
        $this->validate($req, [
            'material_code' => 'required',
            'qty' => 'required|numeric|min:1'
        ]);

        $data['item'] = Item::where('material_code','=',$req->input('material_code'))->first();

        if(!is_null($data['item'])){
            $data['message'] = "data ditemukan.";
            return response()->json($data,200);
        }else{
            $data['message'] = "data tidak ditemukan.";
            return response()->json($data,404);
        }
    }
}
