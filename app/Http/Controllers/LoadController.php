<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;

class LoadController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function csvtojson($file,$delimiter)
    {
        $csv= file_get_contents($file);
        $array = array_map('str_getcsv', explode(PHP_EOL, $csv));
        return json_encode($array);
    }

    private function csv_to_array($csvfile) {
        $csv = Array();
        $rowcount = 0;
        if (($handle = fopen($csvfile, "r")) !== FALSE) {
            $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
            $header = fgetcsv($handle, $max_line_length);
            $header_colcount = count($header);
            while (($row = fgetcsv($handle, $max_line_length)) !== FALSE) {
                $row_colcount = count($row);
                if ($row_colcount == $header_colcount) {
                    $entry = array_combine($header, $row);
                    $csv[] = $entry;
                }
                else {
                    error_log("csvreader: Invalid number of columns at line " . ($rowcount + 2) . " (row " . ($rowcount + 1) . "). Expected=$header_colcount Got=$row_colcount");
                    return null;
                }
                $rowcount++;
            }
            //echo "Totally $rowcount rows found\n";
            fclose($handle);
        }
        else {
            error_log("csvreader: Could not read CSV \"$csvfile\"");
            return null;
        }
        return $csv;
    }

    public function checkBluejay(Request $req){
        $this->validate($req, [
            'bluejay' => 'required',
        ]);

        $data['bluejayData'] = $this->csv_to_array($req->file('bluejay'));
        $data['message'] = "File sesuai dengan ketentuan.";

        Session::put('bluejayArray',$data['bluejayData']);

        $data['datatable'] = DataTables::of($data['bluejayData'])->make(true);

        return response()->json($data,200);
    }

    public function bluejayTable(Request $req){
        $bluejayList = Session::get('bluejayArray');

        $loads = new Collection;

        for ($i=0; $i < count($bluejayList); $i++) {
            $row = $bluejayList[$i];
            $loads->push([
                'TMS ID' => $row['TMS ID'],
                'Billable Total Rate' => $row['Billable Total Rate'],
                'Closed Date' => $row['Closed Date'],
                'Last Drop Location City' => $row['Last Drop Location City'],
                'Load Status' => $row['Load Status'],
            ]);
        }

        return DataTables::of($loads)->make(true);
    }

}
