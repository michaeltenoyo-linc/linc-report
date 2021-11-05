<?php

namespace App\Http\Controllers\Smart;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;
use App\Models\Dload;
use Yajra\DataTables\Contracts\DataTable;

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateReport(Request $req){
        $bluejayList = Session::get('bluejayArray');
        $reports = new Collection;
        $warning = new Collection;
        $ctr = 1;

        if($req->input('reportType') == "smart_1"){
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
                        if($sj->customer_type == $req->input('customerType')){
                            $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                            $totalHarga = intval($row['Billable Total Rate']) + intval($sj->biaya_bongkar);
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
                                'Overnight Charge' => 0,
                                'Multidrop' => 0,
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
    
            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);
    
            return view('smart.pages.report-preview-smart-1');

        }else if($req->input('reportType') == "smart_2"){
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
        return (Session::get('resultReport'))->downloadExcel("report.xlsx",null,true);
    }
}
