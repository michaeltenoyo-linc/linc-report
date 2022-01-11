<?php

namespace App\Http\Controllers\Loa;

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
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use App\Models\Trucks;
use App\Models\Loa_warehouse;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Support\Facades\Session;
//Model Area
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class TransportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function insert(Request $req){
        $req->validate([
            'customer' => 'required',
            'periode_start' => 'required',
            'periode_end' => 'required',
            'divisi' => 'required',
        ]);

        if($req->input('divisi') == "transport"){
            $newLoa = Loa_transport::create([
                'customer' => $req->input('customer'),
                'periode_start' => $req->input('periode_start'),
                'periode_end' => $req->input('periode_end'),
                'files' => "none",
            ]);

            $filenames = "";

            //FILES CONTROL PDF
            if($req->hasFile('filePDF')){
                $filename = "loa_transport_".strval($newLoa->id).".pdf";
                $req->file('filePDF')->storeAs(
                    'loa_transport', $filename
                );
                $filenames .= $filename.";";
            }

            //IMAGES
            if($req->hasFile('fileImages')){
                $filename = "loa_transport_".strval($newLoa->id).".png";
                $req->file('fileImages')->storeAs(
                    'loa_transport', $filename
                );
                $filenames .= $filename.";";
            }

            //excel
            if($req->hasFile('fileExcel')){
                $filename = "loa_transport_".strval($newLoa->id).".xlxs";
                $req->file('fileExcel')->storeAs(
                    'loa_transport', $filename
                );
                $filenames .= $filename.";";
            }

            if($filenames != ""){
                $newLoa->files = $filenames;
                $newLoa->save();
            }

            return response()->json(['message' => "Berhasil menyimpan LOA baru.", 'id' => $newLoa->id],200);
        }else{
            return response()->json(['message' => 'Server saat ini hanya menyediakan manajemen LOA Warehouse'],500);
        }
    }

    public function getRoutes(Request $req, $id){
        $data = dloa_transport::where('id_loa',$id)->get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $open = '<a class="inline-flex" href="'.url('/loa/action/transport/detail/'.$row->id).'"><button class="btn_yellow">Open</button></a>';
                $btn = $open.'<form id="btn-transport-delete" class="inline-flex"><input name="id" type="hidden" value="'.$row->id.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }

    public function gotoDetailTransport(Request $req, $id){
        $data['loa'] = Loa_transport::find($id);
        $start = Carbon::createFromFormat('Y-m-d',$data['loa']->periode_start)->format("d/m/Y");
        $end = Carbon::createFromFormat('Y-m-d',$data['loa']->periode_end)->format('d/m/Y');
        $data['periode'] = $start." - ".$end;

        //FILES BACK-END
        $data['files'] = explode(';',$data['loa']->files);
        $data['filesFormat'] = [];
        $data['filesCount'] = 0;

        foreach ($data['files'] as $file) {
            if($file != "" && $file != "none"){
                $splitName = explode('.',$file);
                array_push($data['filesFormat'],$splitName[1]);
                $data['filesCount']++;
            }
        }

        return view('loa.pages.nav-loa-detail-transport',$data);
    }

    public function searchTransport(Request $req){
        $customer = "";
        $ruteStart = $req->input('route_start');
        $ruteEnd = $req->input('route_end');

        if($req->has('customer')){
            $customer = $req->input('customer');
        }

        $loas = Loa_transport::where('customer','LIKE', '%'.$customer.'%')->whereDate('periode_end', '>=', Carbon::now())->get();

        $listStart = [];
        $listEnd = [];
        $listAreaStart = [];
        $listAreaEnd = [];
        $start = "";
        $end = "";
        //CEK AREA RUTE START
        if(Province::where('name', '=',$ruteStart)->first() != null){
            $prov = Province::where('name', '=',$ruteStart)->first();

            //down
            $kota = Regency::where('province_id', $prov->id)->get();
            $kec = District::whereIn('regency_id', $kota->pluck('id'))->get();
            $kel = Village::whereIn('district_id', $kec->pluck('id'))->get();

            array_push($listStart, $prov->name);
            array_push($listStart, $kota->pluck('name'));
            array_push($listStart, $kec->pluck('name'));
            array_push($listStart, $kel->pluck('name'));
            $start = "prov";

            array_push($listAreaStart, $listStart[0]);
            foreach ($listStart[1] as $a) {
                array_push($listAreaStart, explode(" ",$a)[1]);
            }
            foreach ($listStart[2] as $a) {
                array_push($listAreaStart, $a);
            }
            foreach ($listStart[3] as $a) {
                array_push($listAreaStart, $a);
            }
        }else if(Regency::where('name', '=',$ruteStart)->first() != null){
            $kota = Regency::where('name', '=',$ruteStart)->first();

            //up
            $prov = Province::where('id', $kota->province_id)->first();
            //down
            $kec = District::where('regency_id', $kota->id)->get();
            $kel = Village::whereIn('district_id', $kec->pluck('id'))->get();

            array_push($listStart, $prov->name);
            array_push($listStart, $kota->name);
            array_push($listStart, $kec->pluck('name'));
            array_push($listStart, $kel->pluck('name'));
            $start = "kota";

            array_push($listAreaStart, $listStart[0]);
            array_push($listAreaStart, explode(" ",$listStart[1])[1]);
            foreach ($listStart[2] as $a) {
                array_push($listAreaStart, $a);
            }
            foreach ($listStart[3] as $a) {
                array_push($listAreaStart, $a);
            }
        }else if(District::where('name', '=',$ruteStart)->first() != null){
            $kec = District::where('name', '=',$ruteStart)->first();

            //up
            $kota = Regency::where('id',$kec->regency_id)->first();
            $prov = Province::where('id',$kota->province_id)->first();
            //down
            $kel = Village::where('district_id',$kec->id)->get();

            array_push($listStart, $prov->name);
            array_push($listStart, $kota->name);
            array_push($listStart, $kec->name);
            array_push($listStart, $kel->pluck('name'));
            $start = "kec";

            array_push($listAreaStart, $listStart[0]);
            array_push($listAreaStart, explode(" ",$listStart[1])[1]);
            array_push($listAreaStart, $listStart[2]);
            foreach ($listStart[3] as $a) {
                array_push($listAreaStart, $a);
            }
        }else{
            $kel = Village::where('name', '=',$ruteStart)->first();

            //up
            $kec = District::where('id',$kel->district_id)->first();
            $kota = Regency::where('id', $kec->regency_id)->first();
            $prov = Province::where('id', $kota->province_id)->first();

            array_push($listStart, $prov->name);
            array_push($listStart, $kota->name);
            array_push($listStart, $kec->name);
            array_push($listStart, $kel->name);
            $start = "kel";

            array_push($listAreaStart, $listStart[0]);
            array_push($listAreaStart, explode(" ",$listStart[1])[1]);
            array_push($listAreaStart, $listStart[2]);
            array_push($listAreaStart, $listStart[3]);
        }

        //CEK AREA RUTE END
        if(Province::where('name', '=',$ruteEnd)->first() != null){
            $prov = Province::where('name', '=',$ruteEnd)->first();

            //down
            $kota = Regency::where('province_id', $prov->id)->get();
            $kec = District::whereIn('regency_id', $kota->pluck('id'))->get();
            $kel = Village::whereIn('district_id', $kec->pluck('id'))->get();

            array_push($listEnd, $prov->name);
            array_push($listEnd, $kota->pluck('name'));
            array_push($listEnd, $kec->pluck('name'));
            array_push($listEnd, $kel->pluck('name'));
            $end = "prov";

            array_push($listAreaEnd, $listEnd[0]);
            foreach ($listEnd[1] as $a) {
                array_push($listAreaEnd, explode(" ",$a)[1]);
            }
            foreach ($listEnd[2] as $a) {
                array_push($listAreaEnd, $a);
            }
            foreach ($listEnd[3] as $a) {
                array_push($listAreaEnd, $a);
            }
        }else if(Regency::where('name', '=',$ruteEnd)->first() != null){
            $kota = Regency::where('name', '=',$ruteEnd)->first();

            //up
            $prov = Province::where('id', $kota->province_id)->first();
            //down
            $kec = District::where('regency_id', $kota->id)->get();
            $kel = Village::whereIn('district_id', $kec->pluck('id'))->get();

            array_push($listEnd, $prov->name);
            array_push($listEnd, $kota->name);
            array_push($listEnd, $kec->pluck('name'));
            array_push($listEnd, $kel->pluck('name'));
            $end = "kota";

            array_push($listAreaEnd, $listEnd[0]);
            array_push($listAreaEnd, explode(" ",$listEnd[1])[1]);
            foreach ($listEnd[2] as $a) {
                array_push($listAreaEnd, $a);
            }
            foreach ($listEnd[3] as $a) {
                array_push($listAreaEnd, $a);
            }
        }else if(District::where('name', '=',$ruteEnd)->first() != null){
            $kec = District::where('name', '=',$ruteEnd)->first();

            //up
            $kota = Regency::where('id',$kec->regency_id)->first();
            $prov = Province::where('id',$kota->province_id)->first();
            //down
            $kel = Village::where('district_id',$kec->id)->get();

            array_push($listEnd, $prov->name);
            array_push($listEnd, $kota->name);
            array_push($listEnd, $kec->name);
            array_push($listEnd, $kel->pluck('name'));
            $end = "kec";

            array_push($listAreaEnd, $listEnd[0]);
            array_push($listAreaEnd, explode(" ",$listEnd[1])[1]);
            array_push($listAreaEnd, $listEnd[2]);
            foreach ($listEnd[3] as $a) {
                array_push($listAreaEnd, $a);
            }
        }else{
            $kel = Village::where('name', '=',$ruteEnd)->first();

            //up
            $kec = District::where('id',$kel->district_id)->first();
            $kota = Regency::where('id', $kec->regency_id)->first();
            $prov = Province::where('id', $kota->province_id)->first();

            array_push($listEnd, $prov->name);
            array_push($listEnd, $kota->name);
            array_push($listEnd, $kec->name);
            array_push($listEnd, $kel->name);
            $end = "kel";

            array_push($listAreaEnd, $listEnd[0]);
            array_push($listAreaEnd, explode(" ",$listEnd[1])[1]);
            array_push($listAreaEnd, $listEnd[2]);
            array_push($listAreaEnd, $listEnd[3]);
        }

        $listDloa = [];
        //GET DLOA WITH LOOP ALL AREA
        foreach ($loas as $loa) {
            foreach ($listAreaStart as $s) {
                foreach ($listAreaEnd as $e) {
                    $tempDloa = dloa_transport::where('id_loa',$loa->id)->where('rute_start','LIKE','%'.$s.'%')->where('rute_end','LIKE','%'.$e.'%')->get();
                    if($tempDloa != null){
                        foreach ($tempDloa as $td) {
                            $td->customer = $loa->customer;
                            array_push($listDloa, $td);
                        }
                    }
                }
            }
        }
        
        //sort array by customer
        usort($listDloa, function($a, $b){
            return $a->customer <=> $b->customer;
        });

        return response()->json(['listDloa' => $listDloa,'start'=>$listStart, 'end'=>$listEnd, 'startIs'=>$start, 'endIs'=>$end, 'allAreaStart' => $listAreaStart, 'allAreaEnd' => $listAreaEnd], 200);
    }

    public function searchBillableBlujay(Request $req){
        $req->validate([
            'provinsi1' => 'required',
            'kota1' => 'required',
            'provinsi2' => 'required',
            'kota2' => 'required',
        ]);

        return response()->json(['message' => 'test'], 200);
    }

    public function getDetailLoa(Request $req, $id){
        $dloa = dloa_transport::where('id',$id)->first();
        $loa = Loa_transport::where('id',$dloa->id_loa)->first();

        return response()->json(['data' => $dloa, 'loa' => $loa], 200);
    }
}
