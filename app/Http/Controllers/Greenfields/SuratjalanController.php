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
            'id_so' => 'required',
            'no_do' => 'required',
            'load_id' => 'required',
            'alamat_kirim' => 'required',
            'tgl_kirim' => 'required',
            'customer_name' => 'required',
            'totalWeight' => 'required',
            'bongkar' => 'required',
            'multidrop' => 'required',
            'note' => 'required'
        ]);

        Suratjalan_ltl::create([
            'id_so' => $req->input('id_so'),
            'no_do' => $req->input('no_do'),
            'load_id' => $req->input('load_id'),
            'lokasi_pengiriman' => $req->input('alamat_kirim'),
            'customer_name' => $req->input('customer_name'),
            'total_weightSO' => $req->input('totalWeight'),
            'total_qtySO' => 0,
            'biaya_bongkar' => $req->input('bongkar'),
            'biaya_multidrop' => $req->input('multidrop'),
            'delivery_date' => $req->input('tgl_kirim'),
        ]);

        $data['message'] = "Data surat jalan sudah disimpan.";

        return response()->json($data, 200);
    }

    public function delete(Request $req){
        $sj = Suratjalan_ltl::where('id_so','=',$req->input('id_so'))->where('no_do','=',$req->input('no_do'))->first();
        $sj->delete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }

}
