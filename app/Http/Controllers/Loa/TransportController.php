<?php

namespace App\Http\Controllers\Loa;

use App\Models\BillableBlujay;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
use App\Models\Dload;
use App\Models\Village;

use function PHPUnit\Framework\isNull;

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
            'customer' => 'required',
            'unit' => 'required',
        ]);

        /*
        if( $req->input('customer') == -1 || $req->input('provinsi1') == -1 || $req->input('provinsi2') == -1 || $req->input('kota1') == -1 || $req->input('kota2') == -1){
            return response()->json(['error' => "Invalid input"], 400);
        }*/

        $province1name = "";
        $province2name = "";
        $kota1name = "";
        $kota2name = "";
        $unitName = "";

        //Origin Location        
        if($req->input('provinsi1') == "anywhere"){
            $province1name = "ANYWHERE";
            $kota1name = "ANYWHERE";
        }else if($req->input('provinsi1') == '-1'){
            $province1name = "all";
            $kota1name = "all";
        }else if($req->input('kota1') == '-1'){
            $province1 = Province::where('id','=',$req->input('provinsi1'))->first();
            $province1name = $province1->name;
            $kota1name = "all";
        }else{
            $province1 = Province::where('id','=',$req->input('provinsi1'))->first();
            $province1name = $province1->name;
            
            $kota1 = Regency::where('id','=',$req->input('kota1'))->first();
            $splitKota1 = explode(' ',$kota1->name, 2);
            $kota1name = $splitKota1[1];
        }
        
        //Destination Location
        if($req->input('provinsi2') == "anywhere"){
            $province2name = "ANYWHERE";
            $kota2name = "ANYWHERE";
        }else if($req->input('provinsi2') == '-1'){
            $province2name = "all";
            $kota2name = "all";
        }else if($req->input('kota2') == '-1'){
            $province2 = Province::where('id','=',$req->input('provinsi2'))->first();
            $province2name = $province2->name;
            $kota2name = "all";
        }else{
            $province2 = Province::where('id','=',$req->input('provinsi2'))->first();
            $province2name = $province2->name;
            
            $kota2 = Regency::where('id','=',$req->input('kota2'))->first();
            $splitKota2 = explode(' ',$kota2->name, 2);
            $kota2name = $splitKota2[1];
        }

        //Unit Information
        if($req->input('unit') == '-1'){
            $unitName = "all";
        }else{
            $unitName = $req->input('unit');
        }

        $outData = [];

        $selectedBillable = BillableBlujay::where('customer_reference','=',$req->input('customer'))
                                            ->where('origin_province',$province1name=="all"?'LIKE':'=',$province1name=="all"?'%%':$province1name)
                                            ->where('origin_city',$kota1name=="all"?'LIKE':'=',$kota1name=="all"?'%%':$kota1name)
                                            ->where('destination_province',$province2name=="all"?'LIKE':'=',$province2name=="all"?'%%':$province2name)
                                            ->where('destination_city',$kota2name=="all"?'LIKE':'=',$kota2name=="all"?'%%':$kota2name)
                                            ->where('expiration_date','>=',Carbon::today()->toDateString())
                                            ->where('effective_date','<=',Carbon::today()->toDateString())
                                            ->where('sku',$unitName=="all"?'LIKE':'=',$unitName=="all"?"%%":$unitName)
                                            ->orderBy('origin_location')
                                            ->get();
        
        /* CARA 2 GAGAL
        $fromCompanies = Company::where('city','=',$kota1name)->get();
        $destCompanies = Company::where('city','=',$kota2name)->get();

        error_log("FROM COMP : ".count($fromCompanies));
        error_log("DEST COMP : ".count($destCompanies));

        foreach ($fromCompanies as $from) {
            foreach ($destCompanies as $dest) {
                $tempList = BillableBlujay::where('origin_location','=',$from->reference)->where('destination_location','=',$dest->reference)->get();
                array_push($outData, $tempList);
            }
        }
        */

        /* CARA 1 GAGAL
        $counterSearch = 1;
        foreach ($listBillable as $bill) {
            error_log($counterSearch);
            if($bill->origin_location == "ANYWHERE" && $bill->destination_location == "ANYWHERE"){
                array_push($outData, $bill);
            }else{
                $from = Company::where('reference','=',$bill->origin_location)->first();
                $dest = Company::where('reference','=',$bill->destination_location)->first();

                if(!is_null($dest) && !is_null($from)){
                    if(strtoupper($prov1) == strtoupper($from->province) && strtoupper($prov2) == strtoupper($dest->province) && strtoupper($kota1name) == strtoupper($from->city) && strtoupper($kota2name) == strtoupper($dest->city)){
                        array_push($outData, $bill);
                        error_log("IN BILLABLE");
                    }
                }
            }
            $counterSearch++;
        }
        */

        return response()->json(['billableData' => $selectedBillable], 200);
    }

    public function getDetailLoa(Request $req, $id){
        //$dloa = dloa_transport::where('id',$id)->first();
        //$loa = Loa_transport::where('id',$dloa->id_loa)->first();
        $loa = BillableBlujay::where('id', $id)->first();
        $loa->rate = number_format($loa->rate, 2, ',', '.');

        return response()->json(['loa' => $loa], 200);
    }

    public function crossCompareLoa(Request $req){
        try {
            $req->validate([
                'customer' => 'required',
                'route_start' => 'required',
                'route_end' => 'required',
                'unit' => 'required',
            ]);

            $customer = $req->input('customer');
            $route_start = $req->input('route_start');
            $route_end = $req->input('route_end');
            $unit = $req->input('unit');

            //Local LOA
            $local_loa = Loa_transport::where('customer',$customer)->first();
            $local_dloa = dloa_transport::where('id_loa',$local_loa->id)
                                        ->where('rute_start',$route_start=="-1"?'LIKE':$route_start,$route_start=="-1"?'%%':$route_start)
                                        ->where('rute_end',$route_end=="-1"?'LIKE':$route_end,$route_end=="-1"?'%%':$route_end)
                                        ->where('unit',$unit=="-1"?'LIKE':$unit,$unit=="-1"?'%%':$unit)
                                        ->get();

            $warningLocal = [];
            $warningBlujay = [];


            //Additional conditian for each customer
            $additionalCondition = [];

            if($customer == "SMART RUNGKUT"){
                $additionalCondition = [
                    ['destination_location','NOT LIKE','%(MT)%'],
                ];
            }else if($customer == "SMART MT"){
                $additionalCondition = [
                    ['destination_location','LIKE','%(MT)%'],
                ];
            }

            //COMPARING EACH LOCAL BLUJAY
            foreach ($local_dloa as $local) {
                $start_cross = "";
                $end_cross = "";
                switch ($local->rute_start_cross_relation) {
                    case 'province':
                        $start_cross = "origin_province";
                        break;
                    case 'regency':
                        $start_cross = "origin_city";
                        break;
                    case 'district':
                        $start_cross = "origin_district";
                        break;
                    case 'urban':
                        $start_cross = "origin_urban";
                        break;
                }

                switch ($local->rute_end_cross_relation) {
                    case 'province':
                        $end_cross = "destination_province";
                        break;
                    case 'regency':
                        $end_cross = "destination_city";
                        break;
                    case 'district':
                        $end_cross = "destination_district";
                        break;
                    case 'urban':
                        $end_cross = "destination_urban";
                        break;
                }


                $similarBlujay = BillableBlujay::where('customer_reference',$local_loa->cross_customer_reference)
                                            ->where('expiration_date','>=',Carbon::today()->toDateString())
                                            ->where('effective_date','<=',Carbon::today()->toDateString())
                                            ->where($start_cross, 'LIKE', '%'.$local->rute_start.'%')
                                            ->where($end_cross, 'LIKE', '%'.$local->rute_end.'%')
                                            ->where('sku', 'LIKE', '%'.$local->unit.'%')
                                            ->where($additionalCondition)
                                            ->get();
                
                //array_push($warningLocal, $local);
                //array_push($warningBlujay, $similarBlujay);
                
                //COMPARING EACH BLUJAY
                
                foreach ($similarBlujay as $blujay) {
                    if($blujay->rate != $local->rate){
                        array_push($warningLocal, $local);
                        array_push($warningBlujay, $blujay);
                    }
                }
                
            }

            if(count($warningBlujay) < 1){
                return response()->json(['message' => "Tidak ada perbedaan harga pada blujay", 404]);
            }else{
                $data['warning_local'] = $warningLocal;
                $data['warning_blujay'] =$warningBlujay;
                $data['message'] = "Terdapat beberapa perbedaan harga antara Bluja dan Lokal";

                return response()->json($data, 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th], 400);
        }
    }
}
