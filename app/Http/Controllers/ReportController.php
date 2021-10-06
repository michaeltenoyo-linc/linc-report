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
                        'Tgl Muat' => $sj->tgl_muat,
                        'No SJ' => $sj->id_so,
                        'Penerima' => $sj->penerima,
                        'Kota Tujuan' => $row['Last Drop Location City'],
                        'Kuantitas' => $sj->total_qtySO,
                        'Berat' => $sj->total_weightSO,
                        'Utilitas' => $sj->utilitas,
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
            }else{
                $warning->push([
                    'Load ID' => $row['TMS ID'],
                    'Suggestion' => 'none'
                ]);
            }
        }

        Session::put('warningReport',$warning);
        Session::put('resultReport',$reports);

        return view('pages.report-preview');
    }

    public function getPreviewResult(Request $req){
        $collection = Session::get('resultReport');

        return DataTables::of($collection)->make(true);
    }

    public function getPreviewWarning(Request $req){
        $collection = Session::get('warningReport');

        return DataTables::of($collection)->make(true);
    }

    public function downloadExcel(Request $req){
        return (Session::get('resultReport'))->downloadExcel("report.xlsx",null,true);
    }
}
