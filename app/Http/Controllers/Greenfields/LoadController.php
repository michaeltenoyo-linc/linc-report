<?php

namespace App\Http\Controllers\Greenfields;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;

class LoadController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function csvstring_to_array($string, $separatorChar = ';', $enclosureChar = '"', $newlineChar = "\n") {
        // @author: Klemen Nagode
        $array = array();
        $size = strlen($string);
        $columnIndex = 0;
        $rowIndex = 0;
        $fieldValue="";
        $isEnclosured = false;
        for($i=0; $i<$size;$i++) {

            $char = $string{$i};
            $addChar = "";

            if($isEnclosured) {
                if($char==$enclosureChar) {

                    if($i+1<$size && $string{$i+1}==$enclosureChar){
                        // escaped char
                        $addChar=$char;
                        $i++; // dont check next char
                    }else{
                        $isEnclosured = false;
                    }
                }else {
                    $addChar=$char;
                }
            }else {
                if($char==$enclosureChar) {
                    $isEnclosured = true;
                }else {

                    if($char==$separatorChar) {

                        $array[$rowIndex][$columnIndex] = $fieldValue;
                        $fieldValue="";

                        $columnIndex++;
                    }elseif($char==$newlineChar) {
                        echo $char;
                        $array[$rowIndex][$columnIndex] = $fieldValue;
                        $fieldValue="";
                        $columnIndex=0;
                        $rowIndex++;
                    }else {
                        $addChar=$char;
                    }
                }
            }
            if($addChar!=""){
                $fieldValue.=$addChar;

            }
        }

        if($fieldValue) { // save last field
            $array[$rowIndex][$columnIndex] = $fieldValue;
        }
        return $array;
    }

    private function csvtoarray($file)
    {
        $csv= file_get_contents($file);
        $array = $this->csvstring_to_array($csv);
        $header = $array[0];
        $out = new Collection;

        for ($i=0; $i < count($array); $i++) {
            $row = $array[$i];
            if($i > 0){
                $arrayRow = [];
                for ($key=0; $key < count($header); $key++) {
                    $arrayRow[$header[$key]] = $row[$key];
                }
                $out->push($arrayRow);
            }
        }

        return $out;
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

        $data['bluejayData'] = $this->csvtoarray($req->file('bluejay'));
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
            $customerID = substr($row['First Pick Location Name'],0,3);

            $loads->push([
                'TMS ID' => (isset($row['TMS ID'])?$row['TMS ID']:$row['Load ID']),
                'Customer ID' => $customerID,
                'Created Date' => (isset($row['Created Date'])?$row['Created Date']:$row['Order Create Date']),
                'Last Drop Location City' => (isset($row['Last Drop Location City'])?$row['Last Drop Location City']:$row['Delivery Location Name']),
                'Load Status' => $row['Load Status'],
            ]);

            /*
            $loads->push([
                'TMS ID' => $row['Load ID'],
                'Billable Total Rate' => $row['Billable Total Rate'],
                'Created Date' => $row['Order Create Date'],
                'Last Drop Location City' => $row['Delivery Location Name'],
                'Load Status' => $row['Load Status'],
            ]);
            */
        }

        return DataTables::of($loads)->make(true);
    }

}
