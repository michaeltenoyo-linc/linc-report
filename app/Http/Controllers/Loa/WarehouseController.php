<?php

namespace App\Http\Controllers\Loa;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Loa_warehouse;

class WarehouseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function insert(Request $req){
        $req->validate([
            'customer' => 'required',
            'lokasi' => 'required',
            'periode_start' => 'required',
            'periode_end' => 'required',
            'divisi' => 'required',
        ]);

        if($req->input('divisi') == "warehouse"){
            $inputOtherName = ($req->input('other_name'))?$req->input('other_name'):[];
            $inputOtherRate = ($req->input('other_rate'))?$req->input('other_rate'):[];
            $inputUom = $req->input('uom');
            
            $other_name = "";
            $other_rate = "";
            $uom = "";

            for ($i=0; $i < $req->input('ctrOtherName'); $i++) { 
                if(isset($inputOtherName[$i])){
                    $other_name .= strval($inputOtherName[$i]).";";
                }
            }

            for ($i=0; $i < $req->input('ctrOtherRate'); $i++) { 
                if(isset($inputOtherRate[$i])){
                    $other_rate .= strval($inputOtherRate[$i]).";";
                }
            }

            for ($i=0; $i < $req->input('ctrOtherUomWarehouse'); $i++) { 
                if(isset($inputUom[$i])){
                    $uom .= strval($inputUom[$i]).";";
                }
            }
            
            $newLoa = Loa_warehouse::create([
                'customer' => $req->input('customer'),
                'lokasi' => $req->input('lokasi'),
                'periode_start' => $req->input('periode_start'),
                'periode_end' => $req->input('periode_end'),
                'jasa_titip' => $req->input('titip'),
                'handling_in' => $req->input('handling_in'),
                'handling_out' => $req->input('handling_out'),
                'rental_pallete' => $req->input('rental'),
                'loading' => $req->input('loading'),
                'unloading' => $req->input('unloading'),
                'management' => $req->input('management'),
                'other_name' => $other_name,
                'other_rate' => $other_rate,
                'uom' => $uom,
                'files' => "none",
            ]);
            $filenames = "";

            //FILES CONTROL PDF
            if($req->hasFile('filePDF')){
                $filename = "loa_warehouse_".strval($newLoa->id).".pdf";
                $req->file('filePDF')->storeAs(
                    'loa_warehouse', $filename
                );
                $filenames .= $filename.";";
            }

            //IMAGES
            if($req->hasFile('fileImages')){
                $filename = "loa_warehouse_".strval($newLoa->id).".png";
                $req->file('filePDF')->storeAs(
                    'loa_warehouse', $filename
                );
                $filenames .= $filename.";";
            }

            //excel
            if($req->hasFile('fileExcel')){
                $filename = "loa_warehouse_".strval($newLoa->id).".xlxs";
                $req->file('filePDF')->storeAs(
                    'loa_warehouse', $filename
                );
                $filenames .= $filename.";";
            }

            if($filenames != ""){
                $newLoa->files = $filenames;
                $newLoa->save();
            }

            return response()->json(['message' => "Berhasil menyimpan LOA baru."],200);
        }else{
            return response()->json(['message' => 'Server saat ini hanya menyediakan manajemen LOA Warehouse'],500);
        }
    }
}
