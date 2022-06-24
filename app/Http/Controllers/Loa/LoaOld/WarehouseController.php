<?php

namespace App\Http\Controllers\LoaOld;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

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
                $req->file('fileImages')->storeAs(
                    'loa_warehouse', $filename
                );
                $filenames .= $filename.";";
            }

            //excel
            if($req->hasFile('fileExcel')){
                $filename = "loa_warehouse_".strval($newLoa->id).".xlxs";
                $req->file('fileExcel')->storeAs(
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

    public function prolongPeriod(Request $req){
        $loa = Loa_warehouse::where('id',$req->input('id'))->first();

        $end = Carbon::createFromFormat('Y-m-d',$loa->periode_end)->addYear();
        $loa->periode_end = $end;
        $loa->save();

        return response()->json(['message' => 'success'],200);
    }

    public function gotoDetailWarehouse(Request $req, $id){
        $data['loa'] = Loa_warehouse::find($id);
        $start = Carbon::createFromFormat('Y-m-d',$data['loa']->periode_start)->format("d/m/Y");
        $end = Carbon::createFromFormat('Y-m-d',$data['loa']->periode_end)->format('d/m/Y');
        $data['periode'] = $start." - ".$end;

        //LIST BIAYA
        $rateName = [];
        $rate = [];
        $rateUom = [];

        $splitUom = explode(';',$data['loa']->uom);
        $data['uom'] = $splitUom;
        $splitOtherName = explode(';',$data['loa']->other_name);
        $splitOtherRate = explode(';',$data['loa']->other_rate);

        //Biaya Umum
        if($data['loa']->jasa_titip > 0){
            array_push($rateName, "Jasa Titip");
            array_push($rate, $data['loa']->jasa_titip);
            array_push($rateUom, $splitUom[0]);
        }

        if($data['loa']->handling_in > 0){
            array_push($rateName, "HI");
            array_push($rate, $data['loa']->handling_in);
            array_push($rateUom, $splitUom[1]);
        }

        if($data['loa']->handling_out > 0){
            array_push($rateName, "HO");
            array_push($rate, $data['loa']->handling_out);
            array_push($rateUom, $splitUom[2]);
        }

        if($data['loa']->rental_pallete > 0){
            array_push($rateName, "Rental Pallete");
            array_push($rate, $data['loa']->rental_pallete);
            array_push($rateUom, $splitUom[3]);
        }

        if($data['loa']-> loading > 0){
            array_push($rateName, "Loading");
            array_push($rate, $data['loa']->loading);
            array_push($rateUom, $splitUom[4]);
        }

        if($data['loa']->unloading > 0){
            array_push($rateName, "Unloading");
            array_push($rate, $data['loa']->unloading);
            array_push($rateUom, $splitUom[5]);
        }

        if($data['loa']->management > 0){
            array_push($rateName, "Management");
            array_push($rate, $data['loa']->management);
            array_push($rateUom, $splitUom[6]);
        }

        foreach ($splitOtherName as $d) {
            array_push($rateName, $d);
        }

        $ctrUom = 7;
        foreach ($splitOtherRate as $r) {
            array_push($rate, $r);
            array_push($rateUom, $splitUom[$ctrUom]);
            $ctrUom++;
        }

        $data['rateName'] = $rateName;
        $data['rate'] = $rate;
        $data['rateUom'] = $rateUom;
        $data['rateCount'] = count($rate) - 1;
        $data['files'] = explode(';',$data['loa']->files);
        $data['filesFormat'] = [];
        $data['filesCount'] = 0;

        foreach ($data['files'] as $file) {
            if($file != "" && $file !="none"){
                $splitName = explode('.',$file);
                array_push($data['filesFormat'],$splitName[1]);
                $data['filesCount']++;
            }
        }

        return view('loa.pages.nav-loa-detail-warehouse',$data);
    }
}
