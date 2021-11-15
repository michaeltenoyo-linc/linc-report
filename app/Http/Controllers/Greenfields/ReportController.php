<?php

namespace App\Http\Controllers\Greenfields;

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
use App\Models\Suratjalan_greenfields;
use App\Models\Suratjalan_ltl;
use Illuminate\Support\Facades\Date;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Yajra\DataTables\Contracts\DataTable;

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateReport(Request $req){
        /*
        $req->validate([
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        */

        $bluejayList = Session::get('bluejayArray');
        $reports = new Collection;
        $warning = new Collection;
        $ctr = 1;

        if($req->input('reportType') == "pengiriman_greenfields"){
            for ($i=0; $i < count($bluejayList); $i++) {
                $row = $bluejayList[$i];
                $listSJ = Suratjalan_greenfields::where('load_id','=',(isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']))
                            ->get();
                $firstSJ = true;
                $loadExist = False;
                foreach ($reports as $r) {
                    if($r['Load ID'] == (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID'])){
                        $loadExist = True;
                    }
                }
    
                if(count($listSJ) > 0 && !$loadExist){
                    //ISI LAPORAN DISINI PER LOAD ID
                    foreach ($listSJ as $sj) {
                        if($firstSJ){
                            $totalRate = 0;
                            foreach ($bluejayList as $bj) {
                                if((isset($bj['TMS ID'])?$bj['TMS ID']:$bj['Load ID']) == (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID'])){
                                    $totalRate += $bj['Billable Total Rate'];
                                }
                            }

                            $totalInvoices = $totalRate + $sj->other + $sj->multidrop + $sj->unloading;

                            $reports->push([
                                'No.' => $ctr,
                                'Order Date' => Carbon::parse($sj->order_date)->format('d-M-Y'),
                                'No Order' => $sj->no_order,
                                'Area' => $row['Last Drop Location City'],
                                'Quantity' => $sj->qty,
                                'Pol. No' => $row['Vehicle Number'],
                                'Truck Type' => $row['Equipment Description'],
                                'Destination' => $sj->destination,
                                'Rate' => $totalRate,
                                'Other' => $sj->other,
                            ]);
                        }else{

                        }
                    }

                }else{
                    $custId = substr($row['First Pick Location Name'],0,3);

                    if($custId == "NLS"){
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
    
            return view('greenfields.pages.report-preview-ltl-1');
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
