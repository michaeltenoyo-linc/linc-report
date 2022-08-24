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

        if($req->input('reportType') == "monitoring_pkg"){
            foreach ($listSJ as $ticket) {
                
            }

            Session::put('warningReport',$warning);
            Session::put('resultReport',$reports);
            Session::put('totalReport',$ctr-1);

            return view('ltl.pages.report-preview-pkg-1');
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
        return Excel::download(new Ltl_Report1, 'lautanluas.xlsx');
        //return (Session::get('resultReport'))->downloadExcel("report.xlsx",null,true);
    }
}
