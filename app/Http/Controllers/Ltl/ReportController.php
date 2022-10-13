<?php

namespace App\Http\Controllers\Ltl;

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
use App\Models\Company;
use Maatwebsite\Excel\Facades\Excel;
//use Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportController  extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateReport(Request $req)
    {
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
        $listSJ = Suratjalan_ltl::whereBetween('delivery_date', [$req->input('startDate'), $req->input('endDate')])
            ->orderBy('delivery_date', 'asc')->get();


        $listLoadId = [];
        foreach ($listSJ as $sj) {
            array_push($listLoadId, $sj->load_id);
        }

        if ($req->input('reportType') == "proforma_ltl") {
            foreach ($listLoadId as $wantedLoad) {
                //error_log($wantedLoad);
                $row = LoadPerformance::where('tms_id', $wantedLoad)->first();

                if (is_null($row)) {
                    $warning->push([
                        'Load ID' => $wantedLoad,
                        'Customer Pick Location' => "",
                        'Suggestion' => "",
                    ]);
                } else {
                    $listSJ = Suratjalan_ltl::where('load_id', '=', $row->tms_id)
                        ->whereBetween('delivery_date', [$req->input('startDate'), $req->input('endDate')])
                        ->get();
                    $firstSJ = true;
                    $loadExist = False;
                    foreach ($reports as $r) {
                        if ($r['Load ID'] == $row->tms_id) {
                            $loadExist = True;
                        }
                    }

                    if (count($listSJ) > 0 && !$loadExist) {
                        $listBlujayReference = ShipmentBlujay::where('load_id', '=', $row->tms_id)->orderBy('billable_total_rate', 'desc')->first();
                        $transRate = floatval($listBlujayReference->billable_total_rate);
                        $totalWeight = 0;
                        $multidrop = 0;
                        $locationDetail = Company::where('location', $row->last_drop_location_name)->first();
                        foreach ($listSJ as $sj) {
                            $totalWeight += $sj->total_weightSO;
                            if ($sj->biaya_multidrop > 0) {
                                $multidrop = $sj->biaya_multidrop;
                            }
                        }
                        foreach ($listSJ as $sj) {
                            $totalPay = $transRate + $sj->biaya_bongkar + $multidrop;
                            $rateKG = 0;

                            if ($totalWeight != 0) {
                                $rateKG = floor(($totalPay / $totalWeight) * 100) / 100;
                            }
                            if ($firstSJ) {
                                $reports->push([
                                    'No' => $ctr,
                                    'Load ID' => $sj->load_id,
                                    'No SO' => $sj->id_so,
                                    'No DO' => $sj->no_do,
                                    'Delivery Date' => Carbon::parse($sj->delivery_date)->format('d/m/Y'),
                                    'No Polisi' => $row->vehicle_number,
                                    'Customer Name' => $sj->customer_name,
                                    'Customer Address' => $sj->lokasi_pengiriman,
                                    'ID STOP LOCATION' => $row->last_drop_location_name,
                                    'PROVINSI TUJUAN' => strtoupper(is_null($locationDetail) ? "Undefined" : $locationDetail->province),
                                    'KOTA TUJUAN' => strtoupper(is_null($locationDetail) ? "Undefined" : $locationDetail->city),
                                    'Qty' => number_format($sj->total_weightSO, 2, '.', ''),
                                    'Transport Rate' => number_format($transRate, 2, '.', ''),
                                    'Unloading Cost' => number_format($sj->biaya_bongkar, 2, '.', ''),
                                    'Multidrop' => number_format($multidrop, 2, '.', ''),
                                    'Total' => number_format($totalPay, 2, '.', ''),
                                    'Rate / Kg' => number_format($rateKG, 2, '.', ''),
                                    'Invoice To LTL' => number_format($rateKG * $sj->total_weightSO, 2, '.', ''),
                                    'Remarks' => $sj->note,
                                ]);
                                $ctr++;
                                $firstSJ = false;
                            } else {
                                $reports->push([
                                    'No' => $ctr,
                                    'Load ID' => $sj->load_id,
                                    'No SO' => $sj->id_so,
                                    'No DO' => $sj->no_do,
                                    'Delivery Date' => Carbon::parse($sj->delivery_date)->format('d/m/Y'),
                                    'No Polisi' => $row->vehicle_number,
                                    'Customer Name' => $sj->customer_name,
                                    'Customer Address' => $sj->lokasi_pengiriman,
                                    'ID STOP LOCATION' => $row->last_drop_location_name,
                                    'PROVINSI TUJUAN' => strtoupper(is_null($locationDetail) ? "Undefined" : $locationDetail->province),
                                    'KOTA TUJUAN' => strtoupper(is_null($locationDetail) ? "Undefined" : $locationDetail->city),
                                    'Qty' => number_format($sj->total_weightSO, 2, '.', ''),
                                    'Transport Rate' => "",
                                    'Unloading Cost' => "", //number_format($sj->biaya_bongkar,2,'.',''),
                                    'Multidrop' => "",
                                    'Total' => "", //number_format($totalPay,2,'.',''),
                                    'Rate / Kg' => number_format($rateKG, 2, '.', ''),
                                    'Invoice To LTL' => number_format($rateKG * $sj->total_weightSO, 2, '.', ''),
                                    'Remarks' => $sj->note,
                                ]);
                                $ctr++;
                            }
                        }
                        if (count($listSJ) > 1) {
                            $reports->push([
                                'No' => "",
                                'Load ID' => "",
                                'No SO' => "",
                                'No DO' => "",
                                'Delivery Date' => "",
                                'No Polisi' => "",
                                'Customer Name' => "",
                                'Customer Address' => "",
                                'ID STOP LOCATION' => "",
                                'PROVINSI TUJUAN' => "",
                                'KOTA TUJUAN' => "",
                                'Qty' => number_format($totalWeight, 2, '.', ''),
                                'Transport Rate' => "",
                                'Unloading Cost' => "",
                                'Multidrop' => "",
                                'Total' => "",
                                'Rate / Kg' => "",
                                'Invoice To LTL' => "",
                                'Remarks' => ""
                            ]);
                        }
                        $reports->push([
                            'No' => "",
                            'Load ID' => "",
                            'No SO' => "",
                            'No DO' => "",
                            'Delivery Date' => "",
                            'No Polisi' => "",
                            'Customer Name' => "",
                            'Customer Address' => "",
                            'ID STOP LOCATION' => "",
                            'PROVINSI TUJUAN' => "",
                            'KOTA TUJUAN' => "",
                            'Qty' => "",
                            'Transport Rate' => "",
                            'Unloading Cost' => "",
                            'Multidrop' => "",
                            'Total' => "",
                            'Rate / Kg' => "",
                            'Invoice To LTL' => "",
                            'Remarks' => ""
                        ]);
                    } else {
                        /*
                        $custId = substr($row->first_pick_location_name,0,3);

                        if($custId == "LTL"){
                            $warning->push([
                                'Load ID' => $row->tms_id,
                                'Customer Pick Location' => $row->first_pick_location_name,
                                'Suggestion' => (isset($row->shipment_reference_number)?$row->shipment_reference_number:"None"),
                            ]);
                        }*/
                    }
                }
            }

            Session::put('warningReport', $warning);
            Session::put('resultReport', $reports);
            Session::put('totalReport', $ctr - 1);

            return view('ltl.pages.report-preview-ltl-1');
        }
    }

    public function getPreviewResult(Request $req)
    {
        $collection = Session::get('resultReport');
        $totalReport = Session::get('totalReport');

        return DataTables::of($collection)->setTotalRecords($totalReport)->make(true);
    }

    public function getPreviewWarning(Request $req)
    {
        $collection = Session::get('warningReport');

        return DataTables::of($collection)->make(true);
    }

    public function downloadExcel(Request $req)
    {
        return Excel::download(new Ltl_Report1, 'lautanluas.xlsx');
        //return (Session::get('resultReport'))->downloadExcel("report.xlsx",null,true);
    }
}
