<?php

namespace App\Http\Controllers\Pkg;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;
use App\Models\Dload;
use App\Models\LoadPerformance;
use App\Models\Suratjalan_ltl;
use App\Models\ShipmentBlujay;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Yajra\DataTables\Contracts\DataTable;

//Excel
use App\Exports\Ltl_Report1;
use App\Exports\Pkg_Report1;
use App\Models\dsuratjalan_pkg;
use App\Models\Suratjalan_pkg;
use Maatwebsite\Excel\Facades\Excel;
//use Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportController  extends BaseController 
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateReport(Request $req){
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }

        $req->validate([
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        //$bluejayList = Session::get('bluejayArray');
        $reports = new Collection;
        $warning = new Collection;
        $ctr = 1;

        //Baru pake local BLUJAY
        $listSJ = Suratjalan_pkg::whereBetween('terbit', [$req->input('startDate'),$req->input('endDate')])
                                    ->orderBy('terbit','asc')->get();
        $listPosto = Suratjalan_pkg::whereBetween('terbit', [$req->input('startDate'),$req->input('endDate')])
                                        ->orderBy('terbit','asc')->get()->pluck('posto');

        $listLoads = dsuratjalan_pkg::whereIn('posto',$listPosto)->get();
        $listLoadId = dsuratjalan_pkg::whereIn('posto',$listPosto)->get()->pluck('load_id');

        $loadPerformance = LoadPerformance::whereIn('tms_id',$listLoadId)->get();
        
        if($req->input('reportType') == "monitoring_pkg"){
            $ctr = 1;
            foreach ($listSJ as $ticket) {
                $firstLoad = true;
                $balance = $ticket->qty;

                foreach ($listLoads as $booking) {
                    if($booking->posto == $ticket->posto){
                        $loadExist = false;
                        foreach ($loadPerformance as $performance) {
                            if($performance->tms_id == $booking->load_id){
                                $loadExist = true;
                                $balance -= $performance->weight_kg;
                                //INPUT TO REPORT
                                if($firstLoad){
                                    $reports->push([
                                        'No' => $ctr,
                                        'No POSTO' => $ticket->posto,
                                        'Qty POSTO' => $ticket->qty,
                                        'Tgl terbit POSTO' => $ticket->terbit,
                                        'Expired Date' => $ticket->expired,
                                        'Produk' => $ticket->produk,
                                        'No DO' => $booking->no_do,
                                        'Load ID' => $booking->load_id,
                                        'Qty Muat' => $performance->weight_kg,
                                        'Pick Up Date' => $booking->pickup,
                                        'Balance Qty (kg)' => $balance,
                                        'Booking Code' => $booking->booking_code,
                                        'Nopol' => $performance->vehicle_number,
                                        'Tujuan' => $ticket->tujuan,
                                        'Remarks' => $booking->remark,
                                    ]);

                                    $firstLoad = false;
                                }else{
                                    $reports->push([
                                        'No' => '',
                                        'No POSTO' => '',
                                        'Qty POSTO' => '',
                                        'Tgl terbit POSTO' => '',
                                        'Expired Date' => '',
                                        'Produk' => '',
                                        'No DO' => $booking->no_do,
                                        'Load ID' => $booking->load_id,
                                        'Qty Muat' => $performance->weight_kg,
                                        'Pick Up Date' => $booking->pickup,
                                        'Balance Qty (kg)' => $balance,
                                        'Booking Code' => $booking->booking_code,
                                        'Nopol' => $performance->vehicle_number,
                                        'Tujuan' => $ticket->tujuan,
                                        'Remarks' => $booking->remark,
                                    ]);
                                }
                            }
                        }

                        if(!$loadExist){
                            $warning->push([
                                'Load ID' => $booking->load_id,
                            ]);
                        }
                    }
                } 

                //Blank Space
                $reports->push([
                    'No' => '',
                    'No POSTO' => '',
                    'Qty POSTO' => '',
                    'Tgl terbit POSTO' => '',
                    'Expired Date' => '',
                    'Produk' => '',
                    'No DO' => '',
                    'Load ID' => '',
                    'Qty Muat' => '',
                    'Pick Up Date' => '',
                    'Balance Qty (kg)' => '',
                    'Booking Code' => '',
                    'Nopol' => '',
                    'Tujuan' => '',
                    'Remarks' => '',
                ]);

                $ctr++;
            }

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);

            return view('pkg.pages.report-preview-pkg-1');
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
        return Excel::download(new Pkg_Report1, 'petrokimia.xlsx');
        //return (Session::get('resultReport'))->downloadExcel("report.xlsx",null,true);
    }
}
