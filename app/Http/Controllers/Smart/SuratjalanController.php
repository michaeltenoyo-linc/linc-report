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
use App\Models\Dload;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

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
            'note' => 'required',
            'driver_nmk' => 'required',
            'driver_name' => 'required',
            'total_weight' => 'required',
            'total_utility' => 'required',
            'bongkar' => 'required',
            'overnight' => 'required',
            'multidrop' => 'required',
            'tgl_terima' => 'required',
            'total_qty' => 'required',
        ]);

        $data['message'] = "Data surat jalan sudah disimpan.";
        $thisId = strval($req->input('id_so'));

        if($req->input('no_do')){
           $thisId .= "$".$req->input('no_do'); 
        }

        $new_so = Suratjalan::create([
            'id_so' => $thisId,
            'load_id' => $req->input('load_id'),
            'total_weightSO' => $req->input('total_weight'),
            'nopol' => $req->input('nopol'),
            'driver_nmk' => $req->input('driver_nmk'),
            'driver_name' => $req->input('driver_name'),
            'customer_type' => "",
            'note' => $req->input('note'),
            'penerima' => $req->input('penerima'),
            'utilitas' => $req->input('total_utility'),
            'biaya_bongkar' => $req->input('bongkar'),
            'biaya_overnight' => $req->input('overnight'),
            'biaya_multidrop' => $req->input('multidrop'),
            'tgl_terima' => $req->input('tgl_muat'),
            'total_qtySO' => $req->input('total_qty'),
        ]);

        

        if(!isNull($req->input('item'))){
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
        }

        

        return response()->json($data, 200);
    }

    public function delete(Request $req){
        $sj = Suratjalan::where('id_so','=',$req->input('id_so'))->first();
        $sj->delete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }

}
