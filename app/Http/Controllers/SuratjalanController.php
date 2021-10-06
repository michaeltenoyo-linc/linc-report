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
use App\Models\Dload;

class SuratjalanController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkSj(Request $req, $id_so){
        $temp = Suratjalan::where('id_so','=',$id_so)->first();

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
            'load_id' => 'required',
            'penerima' => 'required',
            'nopol' => 'required',
            'total_weight' => 'required',
            'total_utility' => 'required',
            'item' => 'required',
            'qty' => 'required',
            'bongkar' => 'required',
            'tgl_muat' => 'required',
            'total_qty' => 'required',
        ]);

        $data['message'] = "Data surat jalan sudah disimpan.";

        $new_so = Suratjalan::create([
            'id_so' => $req->input('id_so'),
            'load_id' => $req->input('load_id'),
            'total_weightSO' => $req->input('total_weight'),
            'nopol' => $req->input('nopol'),
            'penerima' => $req->input('penerima'),
            'utilitas' => $req->input('total_utility'),
            'biaya_bongkar' => $req->input('bongkar'),
            'tgl_muat' => $req->input('tgl_muat'),
            'total_qtySO' => $req->input('total_qty'),
        ]);

        //DLOADS
        $itemList = $req->input('item');
        $qtyList = $req->input('qty');

        for ($i=0; $i < count($itemList); $i++) {
            $tempItem = Item::where('material_code','=',$itemList[$i])->first();
            $subtotal_weight = $tempItem->gross_weight * $qtyList[$i];

            Dload::create([
                'id_so' => $new_so->id_so,
                'nopol' => $req->input('nopol'),
                'material_code' => $itemList[$i],
                'qty' => $qtyList[$i],
                'subtotal_weight' => $subtotal_weight,
            ]);
        }

        return response()->json($data, 200);
    }

}
