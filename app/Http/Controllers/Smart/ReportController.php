<?php

namespace App\Http\Controllers\Smart;

use App\Exports\Smart_Report1;
use App\Exports\Smart_Report2;
use App\Exports\Smart_Report3;
use App\Models\Addcost;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;
use App\Models\Dload;
use App\Models\LoadPerformance;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Yajra\DataTables\Contracts\DataTable;

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateReport(Request $req){
        $req->validate([
            'customerType' => 'required',
            'loadId' => 'required',
        ]);

        /*
        $bluejayList = Session::get('bluejayArray');
        */
        $reports = new Collection;
        $warning = new Collection;
        $listLoadId = explode(';',$req->input('loadId'));
        $ctr = 1;

        //Untuk Report 2
        $SjReport2 = Suratjalan::orderBy('created_at','asc')->get();

        if($req->input('reportType') == "smart_1"){

            foreach ($listLoadId as $wantedLoad) {
                $row = LoadPerformance::where('tms_id',$wantedLoad)->first();
                if($row != ""){
                    $listSJ = Suratjalan::where('load_id','=',$row->tms_id)->get();
                    $loadExist = False;
                    foreach ($reports as $r) {
                        if($r['Load ID'] == $row->tms_id){
                            $loadExist = True;
                        }
                    }

                    //Addcost
                    $totalBongkar = 0;
                    $totalMultidrop = 0;
                    $totalOvernight = 0;

                    $listBongkar = Addcost::where('type','TMB_BONGKAR')->where('load_id',$row->tms_id)->get();
                    $listMultidrop = Addcost::where('type','TMB_MULTIDROP')->where('load_id',$row->tms_id)->get();
                    $listOvernight = Addcost::where('type','TMB_BIAYA INAP (OVERNIGHT CHARGE)')->where('load_id',$row->tms_id)->get();

                    if(count($listBongkar) > 0){
                        foreach ($listBongkar as $bongkar) {
                            $totalBongkar += $bongkar->rate;
                        }                    
                    }

                    if(count($listMultidrop) > 0){
                        foreach ($listMultidrop as $multidrop) {
                            $totalMultidrop += $multidrop->rate;
                        }                    
                    }

                    if(count($listOvernight) > 0){
                        foreach ($listOvernight as $overnight) {
                            $totalOvernight += $overnight->rate;
                        }                    
                    }

                    //LISTING SURAT JALAN
                    if(count($listSJ) > 0 && !$loadExist){
                        //Check multidrop
                        $isMultidrop = false;
                        $listPenerima = [];
                        foreach ($listSJ as $sj) {
                            array_push($listPenerima, $sj->penerima);
                        }
                        $uniqueCount = count(array_count_values($listPenerima));
                        $uniqueCount>1?$isMultidrop=true:$isMultidrop=false;
                        if(!$isMultidrop){
                            $totalMultidrop = 0;
                        }

                        foreach ($listSJ as $sj) {
                            $firstline = true;
                            $isWanted = false;

                            foreach ($listLoadId as $load) {
                                if($sj->load_id == $load){
                                    $isWanted = true;
                                }
                            }
                            
                            if($req->input('customerType') == "all"){
                                $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                                //$totalHarga = intval($row->billable_total_rate) + $totalOvernight + $totalBongkar + $totalMultidrop;
                                $splitID = explode('$',$sj->id_so);

                                $dload = Dload::where('id_so','=',$sj->id_so)->get();

                                foreach ($dload as $item) {
                                    $itemDetail = Item::where('material_code','=',$item->material_code)->first();
                                    $locationDetail = Company::where('reference',$row->last_drop_location_name)->first();

                                    if($firstline){
                                        $reports->push([
                                            'No' => $ctr,
                                            'Load ID' => $row->tms_id,
                                            'Customer Type' => strtoupper($sj->customer_type),
                                            'Tgl Muat' => Carbon::parse($sj->tgl_terima)->format('d-M-Y'),
                                            'No SJ' => $splitID[0],
                                            'No DO' => (isset($splitID[1])?$splitID[1]:"-"),
                                            'Penerima' => $sj->penerima,
                                            'Lokasi Tujuan' => $row->last_drop_location_name,
                                            'Provinsi Tujuan' => strtoupper(is_null($locationDetail)?"Undefined":$locationDetail->province),
                                            'Kota Tujuan' => strtoupper(is_null($locationDetail)?"Undefined":$locationDetail->city),
                                            'Kuantitas' => $sj->total_qtySO,
                                            'Berat' => $sj->total_weightSO,
                                            'Utilitas' => strval($sj->utilitas)."%",
                                            'Nopol' => $sj->nopol,
                                            'Tipe Kendaraan' => $row->equipment_description,
                                            'Kontainer' => "-",
                                            'Biaya Kirim' => intval($row->billable_total_rate) - $totalOvernight - $totalBongkar - $totalMultidrop,
                                            'Biaya Bongkar' => $totalBongkar,
                                            'Overnight Charge' => $totalOvernight,
                                            'Multidrop' => $totalMultidrop,
                                            'Total' => intval($row->billable_total_rate),
                                            'Kode SKU' => $item->material_code,
                                            'Deskripsi' => $itemDetail->description,
                                            'Qty' => $item->qty,
                                            'Item Weight' => $itemDetail->gross_weight,
                                            'Subtotal Weight' => $item->subtotal_weight,
                                        ]);

                                        $firstline = false;
                                    }else{
                                        $reports->push([
                                            'No' => " ",
                                            'Load ID' => " ",
                                            'Customer Type' => " ",
                                            'Tgl Muat' => " ",
                                            'No SJ' => " ",
                                            'No DO' => " ",
                                            'Penerima' => " ",
                                            'Lokasi Tujuan' => " ",
                                            'Provinsi Tujuan' => " ",
                                            'Kota Tujuan' => " ",
                                            'Kuantitas' => " ",
                                            'Berat' => " ",
                                            'Utilitas' => " ",
                                            'Nopol' => " ",
                                            'Tipe Kendaraan' => " ",
                                            'Kontainer' => " ",
                                            'Biaya Kirim' => " ",
                                            'Biaya Bongkar' => " ",
                                            'Overnight Charge' =>" ",
                                            'Multidrop' => " ",
                                            'Total' => " ",
                                            'Kode SKU' => $item->material_code,
                                            'Deskripsi' => $itemDetail->description,
                                            'Qty' => $item->qty,
                                            'Item Weight' => $itemDetail->gross_weight,
                                            'Subtotal Weight' => $item->subtotal_weight,
                                        ]);
                                    }
                                }

                                $ctr++;
                            }
                        }
                        $reports->push([
                            'No' => " ",
                            'Load ID' => " ",
                            'Customer Type' => " ",
                            'Tgl Muat' => " ",
                            'No SJ' => " ",
                            'No DO' => " ",
                            'Penerima' => " ",
                            'Lokasi Tujuan' => " ",
                            'Provinsi Tujuan' => " ",
                            'Kota Tujuan' => " ",
                            'Kuantitas' => " ",
                            'Berat' => " ",
                            'Utilitas' => " ",
                            'Nopol' => " ",
                            'Tipe Kendaraan' => " ",
                            'Kontainer' => " ",
                            'Biaya Kirim' => " ",
                            'Biaya Bongkar' => " ",
                            'Overnight Charge' =>" ",
                            'Multidrop' => " ",
                            'Total' => " ",
                            'Kode SKU' => " ",
                            'Deskripsi' => " ",
                            'Qty' => " ",
                            'Item Weight' => " ",
                            'Subtotal Weight' => " ",
                        ]);
                    }else if(count($listSJ) == 0){
                        $custId = substr($row->first_pick_location_name,0,3);

                        if($custId == "SMR"){
                            $warning->push([
                                'Load ID' => $row->tms_id,
                                'Customer Pick Location' => $row->first_pick_location_name,
                                'Suggestion' => (isset($row->shipment_reference)?$row->shipment_reference:"None"),

                            ]);
                        }
                    }
                }else{
                    $warning->push([
                        'Load ID' => $wantedLoad,
                        'Customer Pick Location' => "",
                        'Suggestion' => "Load ID Not Found in database",
                    ]);
                }
            }

            /*
            for ($i=0; $i < count($bluejayList); $i++) {
                $row = $bluejayList[$i];
                $listSJ = Suratjalan::where('load_id','=',(isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']))->get();
                $loadExist = False;
                foreach ($reports as $r) {
                    if($r['Load ID'] == (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID'])){
                        $loadExist = True;
                    }
                }

                if(count($listSJ) > 0 && !$loadExist){
                    foreach ($listSJ as $sj) {
                        $isWanted = false;

                        foreach ($listLoadId as $load) {
                            if($sj->load_id == $load){
                                $isWanted = true;
                            }
                        }
                        
                        if($req->input('customerType') == "all" && $isWanted || $sj->customer_type == $req->input('customerType') && $isWanted){
                            $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                            $totalHarga = intval($row['Billable Total Rate']) + intval($sj->biaya_bongkar) + intval($sj->biaya_multidrop) + intval($sj->biaya_overnight);
                            $splitID = explode('$',$sj->id_so);
                            $reports->push([
                                'No' => $ctr,
                                'Load ID' => $row['TMS ID'],
                                'Tgl Muat' => Carbon::parse($sj->tgl_muat)->format('d-M-Y'),
                                'No SJ' => $splitID[0],
                                'No DO' => (isset($splitID[1])?$splitID[1]:""),
                                'Penerima' => $sj->penerima,
                                'Kota Tujuan' => $row['Last Drop Location City'],
                                'Kuantitas' => $sj->total_qtySO,
                                'Berat' => $sj->total_weightSO,
                                'Utilitas' => strval($sj->utilitas)."%",
                                'Nopol' => $sj->nopol,
                                'Tipe Kendaraan' => $truck->type,
                                'Kontainer' => "-",
                                'Biaya Kirim' => $row['Billable Total Rate'],
                                'Biaya Bongkar' => $sj->biaya_bongkar,
                                'Overnight Charge' => $sj->biaya_overnight,
                                'Multidrop' => $sj->biaya_multidrop,
                                'Total' => $totalHarga,
                            ]);
                            $ctr++;
                        }
                    }
                    $reports->push([
                        'No' => " ",
                        'Load ID' => " ",
                        'Tgl Muat' => " ",
                        'No SJ' => " ",
                        'No DO' => " ",
                        'Penerima' => " ",
                        'Kota Tujuan' => " ",
                        'Kuantitas' => " ",
                        'Berat' => " ",
                        'Utilitas' => " ",
                        'Nopol' => " ",
                        'Tipe Kendaraan' => " ",
                        'Kontainer' => " ",
                        'Biaya Kirim' => " ",
                        'Biaya Bongkar' => " ",
                        'Overnight Charge' =>" ",
                        'Multidrop' => " ",
                        'Total' => " ",
                    ]);
                }else{
                    $custId = substr($row['First Pick Location Name'],0,3);

                    if($custId == "SMR"){
                        $warning->push([
                            'Load ID' => (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']),
                            'Customer Pick Location' => $row['First Pick Location Name'],
                            'Suggestion' => (isset($row['Shipment Reference Numbers'])?$row['Shipment Reference Numbers']:"None"),

                        ]);
                    }
                }
            }
            */

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);
            Session::put('reportType',$req->input('reportType'));

            return view('smart.pages.report-preview-smart-1');

        }elseif ($req->input('reportType') == "smart_2") {
            foreach ($SjReport2 as $sj) {
                $firstline = true;

                $dload = Dload::where('id_so','=',$sj->id_so)->get();
                $splitID = explode('$',$sj->id_so);
                $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                $blujay = LoadPerformance::where('tms_id', $sj->load_id)->first();


                foreach ($dload as $items) {
                    $itemDetail = Item::where('material_code','=',$items->material_code)->first();
                    if ($firstline) {
                        
                        $reports->push([
                            'No' => $ctr,
                            'No SJ' => $splitID[0],
                            'No DO' => (isset($splitID[1])?$splitID[1]:""),
                            'Tanggal Input' => $sj->created_at,
                            'Update Terakhir' => $sj->updated_at,
                            'Load ID' => $sj->load_id,
                            'Customer Type' => $sj->customer_type,
                            'Tgl Muat' => Carbon::parse($sj->tgl_muat)->format('d-M-Y'),
                            'Penerima' => $sj->penerima,
                            'Kuantitas' => $sj->total_qtySO,
                            'Berat' => $sj->total_weightSO,
                            'Utilitas' => strval($sj->utilitas)."%",
                            'City Routes'=>is_null($blujay)?"UNDEFINED":$blujay->first_pick_location_city." - ".$blujay->last_drop_location_city,
                            'Nopol' => $sj->nopol,
                            'Driver' => $sj->driver_name,
                            'Tipe Kendaraan' => $truck->type,
                            'Kontainer' => "-",
                            'Biaya Bongkar' => $sj->biaya_bongkar,
                            'Overnight Charge' => $sj->biaya_overnight,
                            'Multidrop' => $sj->biaya_multidrop,
                            'Kode SKU' => $items->material_code,
                            'Deskripsi' => $itemDetail->description,
                            'Qty' => $items->qty,
                            'Retur' => $items->retur,
                            'Subtotal Weight' => $items->subtotal_weight,
                        ]);
                        $firstline = false;
                        $ctr++;
                    }else{
                        $reports->push([
                            'No' => "",
                            'No SJ' => "",
                            'No DO' => "",
                            'Tanggal Input' => "",
                            'Update Terakhir' => "",
                            'Load ID' => "",
                            'Customer Type' => "",
                            'Tgl Muat' => "",
                            'Penerima' => "",
                            'Kuantitas' => "",
                            'Berat' => "",
                            'Utilitas' => "",
                            'City Routes'=>"",
                            'Nopol' => "",
                            'Driver' => "",
                            'Tipe Kendaraan' => "",
                            'Kontainer' => "",
                            'Biaya Bongkar' => "",
                            'Overnight Charge' => "",
                            'Multidrop' => "",
                            'Kode SKU' => $items->material_code,
                            'Deskripsi' => $itemDetail->description,
                            'Qty' => $items->qty,
                            'Retur' => $items->retur,
                            'Subtotal Weight' => $items->subtotal_weight,
                        ]);
                    }
                }

                $reports->push([
                    'No' => "",
                    'No SJ' => "",
                    'No DO' => "",
                    'Tanggal Input' => "",
                    'Update Terakhir' => "",
                    'Load ID' => "",
                    'Customer Type' => "",
                    'Tgl Muat' => "",
                    'Penerima' => "",
                    'Kuantitas' => "",
                    'Berat' => "",
                    'Utilitas' => "",
                    'City Routes'=>"",
                    'Nopol' => "",
                    'Driver' => "",
                    'Tipe Kendaraan' => "",
                    'Kontainer' => "",
                    'Biaya Bongkar' => "",
                    'Overnight Charge' => "",
                    'Multidrop' => "",
                    'Kode SKU' => "",
                    'Deskripsi' => "",
                    'Qty' => "",
                    'Retur' => "",
                    'Subtotal Weight' => "",
                ]);
            }

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);
            Session::put('reportType',$req->input('reportType'));

            return view('smart.pages.report-preview-smart-1');
        }else if($req->input('reportType') == "smart_3"){

            foreach ($listLoadId as $wantedLoad) {
                $row = LoadPerformance::where('tms_id',$wantedLoad)->first();
                if($row != ""){
                    $listSJ = Suratjalan::where('load_id','=',$row->tms_id)->get();
                    $loadExist = False;
                    foreach ($reports as $r) {
                        if($r['Load ID'] == $row->tms_id){
                            $loadExist = True;
                        }
                    }

                    //Addcost
                    $totalBongkar = 0;
                    $totalMultidrop = 0;
                    $totalOvernight = 0;

                    $listBongkar = Addcost::where('type','TMB_BONGKAR')->where('load_id',$row->tms_id)->get();
                    $listMultidrop = Addcost::where('type','TMB_MULTIDROP')->where('load_id',$row->tms_id)->get();
                    $listOvernight = Addcost::where('type','TMB_BIAYA INAP (OVERNIGHT CHARGE)')->where('load_id',$row->tms_id)->get();

                    if(count($listBongkar) > 0){
                        foreach ($listBongkar as $bongkar) {
                            $totalBongkar += $bongkar->rate;
                        }                    
                    }

                    if(count($listMultidrop) > 0){
                        foreach ($listMultidrop as $multidrop) {
                            $totalMultidrop += $multidrop->rate;
                        }                    
                    }

                    if(count($listOvernight) > 0){
                        foreach ($listOvernight as $overnight) {
                            $totalOvernight += $overnight->rate;
                        }                    
                    }

                    //LISTING SURAT JALAN
                    if(count($listSJ) > 0 && !$loadExist){
                        //Check multidrop
                        $isMultidrop = false;
                        $listPenerima = [];
                        foreach ($listSJ as $sj) {
                            array_push($listPenerima, $sj->penerima);
                        }
                        $uniqueCount = count(array_count_values($listPenerima));
                        $uniqueCount>1?$isMultidrop=true:$isMultidrop=false;
                        if(!$isMultidrop){
                            $totalMultidrop = 0;
                        }

                        foreach ($listSJ as $sj) {
                            $firstline = true;
                            $isWanted = false;

                            foreach ($listLoadId as $load) {
                                if($sj->load_id == $load){
                                    $isWanted = true;
                                }
                            }
                            
                            if($req->input('customerType') == "all"){
                                $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                                //$totalHarga = intval($row->billable_total_rate) + $totalOvernight + $totalBongkar + $totalMultidrop;
                                $splitID = explode('$',$sj->id_so);

                                $dload = Dload::where('id_so','=',$sj->id_so)->get();

                                foreach ($dload as $item) {
                                    $itemDetail = Item::where('material_code','=',$item->material_code)->first();
                                    $locationDetail = Company::where('reference',$row->last_drop_location_name)->first();

                                    if($firstline){
                                        $reports->push([
                                            'No' => $ctr,
                                            'Load ID' => $row->tms_id,
                                            'TANGGAL MUAT' => Carbon::parse($sj->tgl_terima)->format('d-M-Y'),
                                            'No DO' => $splitID[0],
                                            'No SJ' => (isset($splitID[1])?$splitID[1]:"-"),
                                            'CUSTOMER' => $sj->penerima,
                                            'ID STOP LOCATION' => $row->last_drop_location_name,
                                            'PROVINSI TUJUAN' => strtoupper(is_null($locationDetail)?"Undefined":$locationDetail->province),
                                            'KOTA TUJUAN' => strtoupper(is_null($locationDetail)?"Undefined":$locationDetail->city),
                                            'SKU' => $item->material_code,
                                            'DESCRIPTION' => $itemDetail->description,
                                            'QTY' => $item->qty,
                                            'NOPOL' => $sj->nopol,
                                            'TIPE KENDARAAN' => str_replace('_',' ',$row->equipment_description),
                                            'BIAYA TRUKING' => intval($row->billable_total_rate) - $totalOvernight - $totalBongkar - $totalMultidrop,
                                            'BIAYA BONGKAR' => $totalBongkar,
                                            'BIAYA MULTIDROP' => $totalMultidrop,
                                            'BIAYA STAPEL/INAP' => $totalOvernight,
                                            'BIAYA LAIN-LAIN' => 0,
                                            'TOTAL' => intval($row->billable_total_rate),
                                            'CUST TYPE' => strtoupper($sj->customer_type)
                                        ]);

                                        $firstline = false;
                                    }else{
                                        $reports->push([
                                            'No' => "",
                                            'Load ID' => "",
                                            'TANGGAL MUAT' => "",
                                            'No DO' => "",
                                            'No SJ' => "",
                                            'CUSTOMER' => "",
                                            'ID STOP LOCATION' => "",
                                            'PROVINSI TUJUAN' => "",
                                            'KOTA TUJUAN' => "",
                                            'SKU' => $item->material_code,
                                            'DESCRIPTION' => $itemDetail->description,
                                            'QTY' => $item->qty,
                                            'NOPOL' => "",
                                            'TIPE KENDARAAN' => "",
                                            'BIAYA TRUKING' => "",
                                            'BIAYA BONGKAR' => "",
                                            'BIAYA MULTIDROP' => "",
                                            'BIAYA STAPEL/INAP' => "",
                                            'BIAYA LAIN-LAIN' => "",
                                            'TOTAL' => "",
                                            'CUST TYPE' => "",
                                        ]);
                                    }
                                }

                                $ctr++;
                            }
                        }
                        $reports->push([
                            'No' => "",
                            'Load ID' => "",
                            'TANGGAL MUAT' => "",
                            'No DO' => "",
                            'No SJ' => "",
                            'CUSTOMER' => "",
                            'ID STOP LOCATION' => "",
                            'PROVINSI TUJUAN' => "",
                            'KOTA TUJUAN' => "",
                            'SKU' => "",
                            'DESCRIPTION' => "",
                            'QTY' => "",
                            'NOPOL' => "",
                            'TIPE KENDARAAN' => "",
                            'BIAYA TRUKING' => "",
                            'BIAYA BONGKAR' => "",
                            'BIAYA MULTIDROP' => "",
                            'BIAYA STAPEL/INAP' => "",
                            'BIAYA LAIN-LAIN' => "",
                            'TOTAL' => "",
                            'CUST TYPE' => "",
                        ]);
                    }else if(count($listSJ) == 0){
                        $custId = substr($row->first_pick_location_name,0,3);

                        if($custId == "SMR"){
                            $warning->push([
                                'Load ID' => $row->tms_id,
                                'Customer Pick Location' => $row->first_pick_location_name,
                                'Suggestion' => (isset($row->shipment_reference)?$row->shipment_reference:"None"),

                            ]);
                        }
                    }
                }else{
                    $warning->push([
                        'Load ID' => $wantedLoad,
                        'Customer Pick Location' => "",
                        'Suggestion' => "Load ID Not Found in database",
                    ]);
                }
            }

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);
            Session::put('reportType',$req->input('reportType'));

            return view('smart.pages.report-preview-smart-3');

        }
        /*
        else if($req->input('reportType') == "smart_2"){
            for ($i=0; $i < count($bluejayList); $i++) {
                $row = $bluejayList[$i];
                $listSJ = Suratjalan::where('load_id','=',(isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']))->get();
                $loadExist = False;
                foreach ($reports as $r) {
                    if($r['Load ID'] == (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID'])){
                        $loadExist = True;
                    }
                }

                if(count($listSJ) > 0 && !$loadExist){
                    $firstSJ = true;
                    foreach ($listSJ as $sj) {
                        $listDload = Dload::where('id_so','=',$sj->id_so)->get();
                        $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                        $firstDload = true;
                        if(count($listDload) == 0){
                            if($firstSJ && $firstDload){
                                $reports->push([
                                    'No' => $ctr,
                                    'Tanggal' => (isset($row['Created Date'])?$row['Created Date']:$row['Order Create Date']),
                                    'Customer' => $row['Customer Name'],
                                    'Billable Method' => $row['Billable Method'],
                                    'Customer Type' => $row['Shipping Comment'],
                                    'Prodyct ID' => $truck->type,
                                    'Origin' => $row['Pick-up Location Reference Number'],
                                    'Destination' => $row['Delivery Location Name'],
                                    'Penerima Barang' => $sj->penerima,
                                    'Equipment Required' => $truck->type,
                                    'No Order ID' => $row['Order Number'],
                                    'Carrier' => $row['Carrier Name'],
                                    'Nopol' => $sj->nopol,
                                    'Driver' => $sj->driver_name,
                                    'NMK' => $sj->driver_nmk,
                                    'Load ID' => (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']),
                                    'No. DO' => $sj->id_so,
                                    'KODE SKU' => "",
                                    'Description' => "",
                                    'QTY' => "",
                                    'Weight' => "",
                                    'Tanggal SJ Balik' => $sj->tgl_terima,
                                    'Tanggal POD' => $sj->tgl_terima,
                                    'Note Retur' => " ",
                                    'Pengembalian Retur' => " ",
                                ]);
                                $firstSJ = false;
                                $firstDload = false;
                            }else if($firstDload){
                                $reports->push([
                                    'No' => " ",
                                    'Tanggal' => " ",
                                    'Customer' => " ",
                                    'Billable Method' => " ",
                                    'Customer Type' => " ",
                                    'Prodyct ID' => " ",
                                    'Origin' => " ",
                                    'Destination' => " ",
                                    'Penerima Barang' => " ",
                                    'Equipment Required' => " ",
                                    'No Order ID' => " ",
                                    'Carrier' => " ",
                                    'Nopol' => " ",
                                    'Driver' => " ",
                                    'NMK' => " ",
                                    'Load ID' => " ",
                                    'No. DO' => $sj->id_so,
                                    'KODE SKU' => "",
                                    'Description' => "",
                                    'QTY' => "",
                                    'Weight' => "",
                                    'Tanggal SJ Balik' => $sj->tgl_terima,
                                    'Tanggal POD' => $sj->tgl_terima,
                                    'Note Retur' => " ",
                                    'Pengembalian Retur' => " ",
                                ]);
                                $firstDload = false;
                            }else{
                                $reports->push([
                                    'No' => " ",
                                    'Tanggal' => " ",
                                    'Customer' => " ",
                                    'Billable Method' => " ",
                                    'Customer Type' => " ",
                                    'Prodyct ID' => " ",
                                    'Origin' => " ",
                                    'Destination' => " ",
                                    'Penerima Barang' => " ",
                                    'Equipment Required' => " ",
                                    'No Order ID' => " ",
                                    'Carrier' => " ",
                                    'Nopol' => " ",
                                    'Driver' => " ",
                                    'NMK' => " ",
                                    'Load ID' => " ",
                                    'No. DO' => " ",
                                    'KODE SKU' => "",
                                    'Description' => "",
                                    'QTY' => "",
                                    'Weight' => "",
                                    'Tanggal SJ Balik' => " ",
                                    'Tanggal POD' => " ",
                                    'Note Retur' => " ",
                                    'Pengembalian Retur' => " ",
                                ]);
                            }
                        }
                        foreach ($listDload as $dload) {
                            $item = Item::where('material_code','=',$dload->material_code)->first();
                            $totalHarga = intval($row['Billable Total Rate']) + intval($sj->biaya_bongkar);
                            if($firstSJ && $firstDload){
                                $reports->push([
                                    'No' => $ctr,
                                    'Tanggal' => (isset($row['Created Date'])?$row['Created Date']:$row['Order Create Date']),
                                    'Customer' => $row['Customer Name'],
                                    'Billable Method' => $row['Billable Method'],
                                    'Customer Type' => $row['Shipping Comment'],
                                    'Prodyct ID' => $truck->type,
                                    'Origin' => $row['Pick-up Location Reference Number'],
                                    'Destination' => $row['Delivery Location Name'],
                                    'Penerima Barang' => $sj->penerima,
                                    'Equipment Required' => $truck->type,
                                    'No Order ID' => $row['Order Number'],
                                    'Carrier' => $row['Carrier Name'],
                                    'Nopol' => $sj->nopol,
                                    'Driver' => $sj->driver_name,
                                    'NMK' => $sj->driver_nmk,
                                    'Load ID' => (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']),
                                    'No. DO' => $sj->id_so,
                                    'KODE SKU' => $dload->material_code,
                                    'Description' => $item->description,
                                    'QTY' => $dload->qty,
                                    'Weight' => $dload->subtotal_weight,
                                    'Tanggal SJ Balik' => $sj->tgl_terima,
                                    'Tanggal POD' => $sj->tgl_terima,
                                    'Note Retur' => " ",
                                    'Pengembalian Retur' => " ",
                                ]);
                                $firstSJ = false;
                                $firstDload = false;
                            }else if($firstDload){
                                $reports->push([
                                    'No' => " ",
                                    'Tanggal' => " ",
                                    'Customer' => " ",
                                    'Billable Method' => " ",
                                    'Customer Type' => " ",
                                    'Prodyct ID' => " ",
                                    'Origin' => " ",
                                    'Destination' => " ",
                                    'Penerima Barang' => " ",
                                    'Equipment Required' => " ",
                                    'No Order ID' => " ",
                                    'Carrier' => " ",
                                    'Nopol' => " ",
                                    'Driver' => " ",
                                    'NMK' => " ",
                                    'Load ID' => " ",
                                    'No. DO' => $sj->id_so,
                                    'KODE SKU' => $dload->material_code,
                                    'Description' => $item->description,
                                    'QTY' => $dload->qty,
                                    'Weight' => $dload->subtotal_weight,
                                    'Tanggal SJ Balik' => $sj->tgl_terima,
                                    'Tanggal POD' => $sj->tgl_terima,
                                    'Note Retur' => " ",
                                    'Pengembalian Retur' => " ",
                                ]);
                                $firstDload = false;
                            }else{
                                $reports->push([
                                    'No' => " ",
                                    'Tanggal' => " ",
                                    'Customer' => " ",
                                    'Billable Method' => " ",
                                    'Customer Type' => " ",
                                    'Prodyct ID' => " ",
                                    'Origin' => " ",
                                    'Destination' => " ",
                                    'Penerima Barang' => " ",
                                    'Equipment Required' => " ",
                                    'No Order ID' => " ",
                                    'Carrier' => " ",
                                    'Nopol' => " ",
                                    'Driver' => " ",
                                    'NMK' => " ",
                                    'Load ID' => " ",
                                    'No. DO' => " ",
                                    'KODE SKU' => $dload->material_code,
                                    'Description' => $item->description,
                                    'QTY' => $dload->qty,
                                    'Weight' => $dload->subtotal_weight,
                                    'Tanggal SJ Balik' => " ",
                                    'Tanggal POD' => " ",
                                    'Note Retur' => " ",
                                    'Pengembalian Retur' => " ",
                                ]);
                            }
                        }
                    }
                    $ctr++;
                }else{
                    $custId = substr($row['First Pick Location Name'],0,3);

                    if($custId == "SMR"){
                        $warning->push([
                            'Load ID' => (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']),
                            'Customer Pick Location' => $row['First Pick Location Name'],
                            'Suggestion' => (isset($row['Shipment Reference Numbers'])?$row['Shipment Reference Numbers']:"None"),

                        ]);
                    }
                }

            }

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);

            return view('smart.pages.report-preview-smart-2');
        }
        */

    }

    public function getPreviewResult(Request $req){
        $collection = Session::get('resultReport');
        $totalReport = Session::get('totalReport');

        return DataTables::of($collection)->setTotalRecords($totalReport)->make(true);
    }

    public function getPreviewWarning(Request $req){
        $collection = Session::get('warningReport');

        return DataTables::of($collection)->make(true);
    }

    public function downloadExcel(Request $req){
        if(Session::get('reportType') == 'smart_1'){
            return Excel::download(new Smart_Report1, 'smart.xlsx');
        }else if(Session::get('reportType') == "smart_2"){
            return Excel::download(new Smart_Report2, 'smart.xlsx');
        }else if(Session::get('reportType') == "smart_3"){
            return Excel::download(new Smart_Report3, 'smart.xlsx');
        }
    }
}
