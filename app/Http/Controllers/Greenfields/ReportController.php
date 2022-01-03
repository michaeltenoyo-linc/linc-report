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
use App\Models\LoadPerformance;
use App\Models\Suratjalan_greenfields;
use App\Models\Suratjalan_ltl;
use Illuminate\Support\Facades\Date;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Yajra\DataTables\Contracts\DataTable;

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateReport(Request $req){
        $req->validate([
            'loadId' => 'required',
        ]);
        
        $bluejayList = Session::get('bluejayArray');
        $reports = new Collection;
        $warning = new Collection;
        $listLoadId = explode(';',$req->input('loadId'));
        $ctr = 1;

        if($req->input('reportType') == "pengiriman_greenfields"){
            //REVISI BLUJAY LOCAL
            foreach ($listLoadId as $wantedLoad){
                $row = LoadPerformance::where('tms_id',$wantedLoad)->first();
                $listSJ = Suratjalan_greenfields::where('load_id','=',$row->tms_id)
                            ->get();
                $firstSJ = true;
                $loadExist = False;
                foreach ($reports as $r) {
                    if((isset($r['TMS ID'])?$r['TMS ID']:$r['Load ID']) == $row->tms_id){
                        $loadExist = True;
                    }
                }

                if(count($listSJ) > 0 && !$loadExist){
                    //Ambil other, multidrop dan unloading costnya
                    $multidrop = 0;
                    $unloading = 0;
                    $other = 0;
                    foreach ($listSJ as $sj) {
                        if($sj->multidrop > 0){
                            $multidrop = $sj->multidrop;
                        }

                        if($sj->unloading > 0){
                            $unloading = $sj->unloading;
                        }

                        if($sj->other > 0){
                            $other = $sj->other;
                        }
                    }

                    //ISI LAPORAN DISINI PER LOAD ID
                    foreach ($listSJ as $sj) {
                        if($firstSJ){
                            $totalRate = floatval(str_replace(',','',$row->billable_total_rate));

                            $totalInvoices = $totalRate + $other + $multidrop;

                            $reports->push([
                                'No.' => $ctr,
                                'Order Date' => Carbon::parse($sj->order_date)->format('d-M-Y'),
                                'No Order' => $sj->no_order,
                                'Area' => $row->last_drop_location_city,
                                'Quantity' => $sj->qty,
                                'Pol. No' => $row->vehicle_number,
                                'Truck Type' => $row->equipment_description,
                                'Destination' => $sj->destination,
                                'Rate' => $totalRate,
                                'Other' => $other,
                                'Multi Drop' => $multidrop,
                                'Un-Loading' => "-",
                                'Total Invoices' => $totalInvoices,
                                'REMARKS' => $sj->note,
                                'Load ID' => $sj->load_id,
                            ]);
                        }else{
                            $reports->push([
                                'No.' => $ctr,
                                'Order Date' => "",
                                'No Order' => $sj->no_order,
                                'Area' => "",
                                'Quantity' => $sj->qty,
                                'Pol. No' => "",
                                'Truck Type' => "",
                                'Destination' => $sj->destination,
                                'Rate' => "",
                                'Other' => "",
                                'Multi Drop' => "",
                                'Un-Loading' => "",
                                'Total Invoices' => "",
                                'REMARKS' => $sj->note,
                                'Load ID' => $sj->load_id,
                            ]);
                        }
                    }

                }else{
                    $custId = substr($row->first_pick_location_name,0,3);

                    if($custId == "GFD"){
                        $warning->push([
                            'Load ID' => $row->tms_id,
                            'Customer Pick Location' => $row->first_pick_location_name,
                            'Suggestion' => (isset($row->shipment_reference)?$row->shipment_reference:"None"),
                        ]);
                    }
                }
            }

            /*
            for ($i=0; $i < count($bluejayList); $i++) {
                $row = $bluejayList[$i];
                $listSJ = Suratjalan_greenfields::where('load_id','=',(isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']))
                            ->get();
                $firstSJ = true;
                $loadExist = False;
                foreach ($reports as $r) {
                    if((isset($r['TMS ID'])?$r['TMS ID']:$r['Load ID']) == (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID'])){
                        $loadExist = True;
                    }
                }

                if(count($listSJ) > 0 && !$loadExist){
                    //Ambil other, multidrop dan unloading costnya
                    $multidrop = 0;
                    $unloading = 0;
                    $other = 0;
                    foreach ($listSJ as $sj) {
                        if($sj->multidrop > 0){
                            $multidrop = $sj->multidrop;
                        }

                        if($sj->unloading > 0){
                            $unloading = $sj->unloading;
                        }

                        if($sj->other > 0){
                            $other = $sj->other;
                        }
                    }

                    //ISI LAPORAN DISINI PER LOAD ID
                    foreach ($listSJ as $sj) {
                        if($firstSJ){
                            $totalRate = 0;
                            foreach ($bluejayList as $bj) {
                                if((isset($bj['TMS ID'])?$bj['TMS ID']:$bj['Load ID']) == (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID'])){
                                    $totalRate += floatval(str_replace(',','',$bj['Billable Total Rate']));
                                }
                            }

                            $totalInvoices = $totalRate + $other + $multidrop + $unloading;

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
                                'Other' => $other,
                                'Multi Drop' => $multidrop,
                                'Un-Loading' => $unloading,
                                'Total Invoices' => $totalInvoices,
                                'REMARKS' => $sj->note,
                                'Load ID' => $sj->load_id,
                            ]);
                        }else{
                            $reports->push([
                                'No.' => $ctr,
                                'Order Date' => "",
                                'No Order' => $sj->no_order,
                                'Area' => "",
                                'Quantity' => $sj->qty,
                                'Pol. No' => "",
                                'Truck Type' => "",
                                'Destination' => $sj->destination,
                                'Rate' => "",
                                'Other' => "",
                                'Multi Drop' => "",
                                'Un-Loading' => "",
                                'Total Invoices' => "",
                                'REMARKS' => $sj->note,
                                'Load ID' => $sj->load_id,
                            ]);
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
            */

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);

            return view('greenfields.pages.report-preview-greenfields-1');
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
