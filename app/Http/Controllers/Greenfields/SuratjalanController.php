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
use App\Models\Suratjalan;
use App\Models\Dload;
use App\Models\Suratjalan_ltl;
use App\Models\Suratjalan_greenfields;

class SuratjalanController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkSj(Request $req, $id1, $id2){
        $id = $id1."/".$id2;
        $temp = Suratjalan_greenfields::where('no_order','=',$id)->first();

        $data['check'] = false;
        $data['message'] = "Surat jalan sudah terdaftar.";

        if($temp == null){
            $data['check'] = true;
            $data['message'] = "Surat jalan belum terdaftar";
        }



        return response()->json($data,200);
    }

    public function addSj(Request $req){
        $this->validate($req, [
            'order1' => 'required',
            'order2' => 'required',
            'load_id' => 'required',
            'order_date' => 'required',
            'destination' => 'required',
            'qty' => 'required',
            'note' => 'required',
            'multidrop' => 'required',
            'unloading' => 'required',
            'other' => 'required',
        ]);

        Suratjalan_greenfields::create([
            'no_order' => $req->input('order1')."/".$req->input('order2'),
            'load_id' => $req->input('load_id'),
            'order_date' => $req->input('order_date'),
            'qty' => $req->input('qty'),
            'destination' => $req->input('destination'),
            'other' => $req->input('other'),
            'multidrop' => $req->input('multidrop'),
            'unloading' => $req->input('unloading'),
            'note' => $req->input('note')
        ]);

        $data['message'] = "Data surat jalan sudah disimpan.";

        return response()->json($data, 200);
    }

    public function delete(Request $req){
        $sj = Suratjalan_greenfields::where('no_order','=',$req->input('no_order'))->first();
        $sj->forceDelete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }

}
