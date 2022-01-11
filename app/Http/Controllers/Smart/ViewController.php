<?php

namespace App\Http\Controllers\Smart;

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
        return view('smart.pages.landing');
    }

    public function gotoItemNew(){
        return view('smart.pages.nav-items-new');
    }

    public function gotoItemList(){
        return view('smart.pages.nav-items-list');
    }

    public function gotoTrucksList(){
        return view('smart.pages.nav-trucks-list');
    }

    public function gotoTrucksNew(){
        return view('smart.pages.nav-trucks-new');
    }

    public function gotoSoList(){
        return view('smart.pages.nav-so-list');
    }

    public function gotoSoNew(){
        $data['kendaraan'] = Trucks::get();
        $data['items'] = Item::get();

        return view('smart.pages.nav-so-new', $data);
    }

    public function gotoReportGenerate(){
        return view('smart.pages.nav-report-generate');
    }

    //DATA CRAWL
    public function getSj(){
        $data = Suratjalan::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<form id="btn-sj-edit" class="inline-flex"><input name="id_so" type="hidden" value="'.$row->id_so.'"><button type="submit" class="btn_yellow">:)</button></form>';
                $btn = $btn.'<form id="btn-sj-delete" class="inline-flex"><input name="id_so" type="hidden" value="'.$row->id_so.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->addColumn('created_at_format', function($row){
                return date('d-m-Y H:i:s', strtotime($row->created_at));
            })
            ->addColumn('splitId', function($row){
                $splitId = explode('$',$row->id_so);

                if(isset($splitId[1])){
                    return $splitId[0]." [ DO: ".$splitId[1]." ]";
                }else{
                    return $splitId[0]." [ DO: - ]";
                }
            })
            ->make(true);
    }

    public function getItems(){
        $data = Item::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<a href="/smart/items/'.$row->material_code.'" class="btn_yellow">Edit</a>';
                $btn = '<form id="btn-items-delete" class="inline-flex"><input name="materialCode" type="hidden" value="'.$row->material_code.'">'.$btn.'<button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);

    }

    public function getTrucks(){
        $data = Trucks::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<a href="smart/trucks/'.$row->nopol.'" class="btn_yellow">Edit</a>';
                $btn = '<form id="btn-trucks-delete" class="inline-flex"><input name="nopol" type="hidden" value="'.$row->nopol.'">'.$btn.'<button type="submit" class="btn_red">Delete</button></form>';
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
        $filterResult = Item::select('description')->where('description','LIKE','%'.$query.'%')->pluck('description');

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

    public function getItemsFromName(Request $req){
        $this->validate($req, [
            'material_name' => 'required',
            'qty' => 'required|numeric|min:1'
        ]);

        $data['item'] = Item::where('description','=',$req->input('material_name'))->first();

        if(!is_null($data['item'])){
            $data['message'] = "data ditemukan.";
            return response()->json($data,200);
        }else{
            $data['message'] = "data tidak ditemukan.";
            return response()->json($data,404);
        }
    }
}
