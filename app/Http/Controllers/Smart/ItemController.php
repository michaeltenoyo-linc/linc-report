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

class ItemController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkItemExist(Request $req, $material_code){
        $temp = Item::where('material_code','=',$material_code)->first();

        $data['check'] = false;
        $data['message'] = "Item tidak terdaftar.";

        if($temp != null){
            $data['check'] = true;
            $data['message'] = "Item sudah terdaftar.";
        }

        return response()->json($data,200);
    }

    public function addItem(Request $req){
        $this->validate($req, [
            'material_code' => 'required',
            'description' => 'required',
            'gross_weight' => 'required',
            'nett_weight' => 'required',
            'category' => 'required',
        ]);

        Item::create([
            'material_code' => $req->input('material_code'),
            'description' => $req->input('description'),
            'gross_weight' => $req->input('gross_weight'),
            'nett_weight' => $req->input('nett_weight'),
            'category' => $req->input('category')
        ]);

        return response()->json(['message' => "Berhasil menyimpan data."], 200);
    }

    public function delete(Request $req){
        $item = Item::where('material_code','=',$req->input('materialCode'))->first();
        $item->delete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }

    public function update(Request $req){
        $req->validate([
            'material_code' => 'required',
            'description' => 'required',
            'gross' => 'required',
            'net' => 'required',
            'category' => 'required',
        ]);

        $selectedItem = Item::where('material_code','=',$req->input('material_code'))->first();
        $selectedItem->update([
            'material_code' => $req->input('material_code'),
            'description' => $req->input('description'),
            'gross_weight' => $req->input('gross'),
            'nett_weight' => $req->input('net'),
            'category' => $req->input('category'),
        ]);

        return response()->json(['message' => "success"], 200);
    }

}
