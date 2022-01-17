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
use App\Models\LoadPerformance;

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
            'customer_type' => 'required',
            'nopol' => 'required',
            'note' => 'required',
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
            'driver_nmk' => "TBA",
            'driver_name' => "TBA",
            'customer_type' => $req->input('customer_type'),
            'note' => $req->input('note'),
            'penerima' => $req->input('penerima'),
            'utilitas' => $req->input('total_utility'),
            'biaya_bongkar' => $req->input('bongkar'),
            'biaya_overnight' => $req->input('overnight'),
            'biaya_multidrop' => $req->input('multidrop'),
            'tgl_terima' => $req->input('tgl_muat'),
            'total_qtySO' => $req->input('total_qty'),
        ]);



        if(($req->input('total_utility')) > 0){
            //DLOADS
            $itemList = $req->input('item');
            $qtyList = $req->input('qty');
            $returList = $req->input('retur');
            for ($i=0; $i < count($itemList); $i++) {
                $tempItem = Item::where('material_code','=',$itemList[$i])->first();
                $subtotal_weight = $tempItem->gross_weight * $qtyList[$i];

                Dload::create([
                    'id_so' => $new_so->id_so,
                    'nopol' => $req->input('nopol'),
                    'material_code' => $itemList[$i],
                    'qty' => $qtyList[$i],
                    'retur' => $returList[$i],
                    'subtotal_weight' => $subtotal_weight,
                ]);
            }
        }



        return response()->json($data, 200);
    }

    public function delete(Request $req){
        $sj = Suratjalan::where('id_so','=',$req->input('id_so'))->first();
        $dload = Dload::where('id_so','=',$req->input('id_so'))->get();
        foreach ($dload as $r) {
            $r->forceDelete();
        }
        $sj->forceDelete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }

    public function update(Request $req){
        $req->validate([
            'id_so' => 'required',
            'load_id' => 'required',
            'penerima' => 'required',
            'customer_type' => 'required',
            'note' => 'required',
            'bongkar' => 'required',
            'overnight' => 'required',
            'multidrop' => 'required',
        ]);

        $selectedSmart = Suratjalan::where('id_so','=',$req->input('id_so'))->first();

        $selectedSmart->update([
            'penerima' => $req->input('penerima'),
            'customer_type' => $req->input('customer_type'),
            'note' => $req->input('note'),
        ]);

        $selectedLoad = Suratjalan::where('load_id','=',$req->input('load_id'))->get();
        
        foreach ($selectedLoad as $sj) {
            $sj->update([ 
                'biaya_bongkar' => $req->input('bongkar'),
                'biaya_overnight' => $req->input('overnight'),
                'biaya_multidrop' => $req->input('multidrop'),
            ]);
        }

        return response()->json(['message' => "success"],200);
    }
}
