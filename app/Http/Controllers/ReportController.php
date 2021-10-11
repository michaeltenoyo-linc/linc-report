<?php

namespace App\Http\Controllers;

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
                $listSJ = Suratjalan::where('load_id','=',$row['TMS ID'])->get();
    
                if(count($listSJ) > 0){
                    foreach ($listSJ as $sj) {
                        $truck = Trucks::where('nopol','=',$sj->nopol)->first();
                        $totalHarga = intval($row['Billable Total Rate']) + intval($sj->biaya_bongkar);
                        $reports->push([
                            'No' => $ctr,
                            'Load ID' => $row['TMS ID'],
                            'Tgl Muat' => Carbon::parse($sj->tgl_muat)->format('d-M-Y'),
                            'No SJ' => $sj->id_so,
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
                    $reports->push([
                        'No' => " ",
                        'Load ID' => " ",
                        'Tgl Muat' => " ",
                        'No SJ' => " ",
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
                    $warning->push([
                        'Load ID' => $row['TMS ID'],
                        'Suggestion' => $row['Shipment Reference Numbers']
                    ]);
                }
            }
    
            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);
    
            return view('pages.report-preview-smart-1');
        }

        
    }

    public function getPreviewResultSmart1(Request $req){
        $collection = Session::get('resultReport');
        $totalReport = Session::get('totalReport');

        return DataTables::of($collection)->setTotalRecords($totalReport)->make(true);
    }

    public function getPreviewWarningSmart1(Request $req){
        $collection = Session::get('warningReport');

        return DataTables::of($collection)->make(true);
    }

    public function downloadExcel(Request $req){
        return (Session::get('resultReport'))->downloadExcel("report.xlsx",null,true);
    }
}
