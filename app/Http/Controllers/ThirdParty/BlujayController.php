<?php

namespace App\Http\Controllers\ThirdParty;

use App\Models\Addcost;
use App\Models\LoadPerformance;
use App\Models\ShipmentBlujay;
use Google\Service\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Yajra\DataTables\Facades\DataTables;


class BlujayController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function storeData($raw, $type)
    {
        $path = "";
        switch ($type) {
            case 'shipment':
                $path = "../reference/local_blujay/RefreshShipmentBlujay.csv";
                break;
            case 'performance':
                $path = "../reference/local_blujay/LoadPerformanceBlujay.csv";
                break;
            case 'addcost':
                $path = "../reference/local_blujay/RefreshAddcost.csv";
                break;
        }

        $data = strtr($raw, array('-' => '+', '_' => '/'));

        $myfile = fopen($path, "w+");
        fwrite($myfile, base64_decode($data));
        fclose($myfile);
    }

    public function injectSql(Request $req)
    {
        $req->validate([
            'shipment' => 'required',
            'performance' => 'required',
            'addcost' => 'required'
        ]);

        $this->storeData($req->input('shipment'), 'shipment');
        $this->storeData($req->input('performance'), 'performance');
        $this->storeData($req->input('addcost'), 'addcost');

        return response()->json(['message' => "Berhasil inject database"], 200);
    }

    public function checkDateString($str)
    {
        try {
            Carbon::createFromFormat('d/m/Y H:i', $str);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function streamSqlProgress(Request $req)
    {
        return response()->stream(function () {
            //SHIPMENT
            $csvFile = fopen(base_path("reference/local_blujay/RefreshShipmentBlujay.csv"), "r");

            $firstline = true;

            $counter = 1;

            //COUNT
            $fp = file(base_path("reference/local_blujay/RefreshShipmentBlujay.csv"), FILE_SKIP_EMPTY_LINES);
            $length = count($fp);

            while (($data = fgetcsv($csvFile, 0, ',', '"')) != FALSE) {
                $counter++;

                //Progress
                $percentage = round(($counter / $length) * 100, 2);
                $txtPercentage = $percentage . "% (" . $counter . "/" . $length . ")";

                if (!$firstline) {
                    try {
                        ShipmentBlujay::create([
                            'order_number' => $data['5'],
                            'customer_reference' => $data['0'],
                            'customer_name' => $data['1'],
                            'load_id' => $data['2'],
                            'load_group' => $data['11'],
                            'billable_total_rate' => round(floatval(str_replace(',', '', $data['6'])), 2),
                            'payable_total_rate' => round(floatval(str_replace(',', '', $data['9'])), 2),
                            'load_closed_date' => ($this->checkDateString($data['7'])) ? Carbon::createFromFormat('d/m/Y H:i', $data['7']) : null,
                            'load_status' => $data['8'],
                        ]);

                        error_log("Individual Shipment :" . $counter . " (New)", 0);
                    } catch (\Throwable $th) {
                        $exist = ShipmentBlujay::find($data['5']);

                        if (!is_null($exist)) {
                            $exist->forceDelete();
                        }

                        ShipmentBlujay::create([
                            'order_number' => $data['5'],
                            'customer_reference' => $data['0'],
                            'customer_name' => $data['1'],
                            'load_id' => $data['2'],
                            'load_group' => $data['11'],
                            'billable_total_rate' => round(floatval(str_replace(',', '', $data['6'])), 2),
                            'payable_total_rate' => round(floatval(str_replace(',', '', $data['9'])), 2),
                            'load_closed_date' => ($this->checkDateString($data['7'])) ? Carbon::createFromFormat('d/m/Y H:i', $data['7']) : null,
                            'load_status' => $data['8'],
                        ]);

                        error_log("Individual Shipment :" . $counter . " (Exist Updating)", 0);
                    }

                    if ($counter % 100 == 0) {
                        echo "event: shipment\n\n";
                        echo 'data: {"section":"(1/3) Shipment", "percentage": "' . $txtPercentage . '", "total_complete": "' . rand(0, 9999) . '","total_data": "' . rand(0, 9999) . '"}' . "\n\n";

                        ob_flush();
                        flush();
                        if (connection_aborted()) {
                            break;
                        }
                    }
                }

                $firstline = false;
            }

            fclose($csvFile);

            //LOAD PERFORMANCE
            $csvFile = fopen(base_path("reference/local_blujay/LoadPerformanceBlujay.csv"), "r");

            $firstline = true;

            $counter = 1;

            //COUNT
            $fp = file(base_path("reference/local_blujay/LoadPerformanceBlujay.csv"), FILE_SKIP_EMPTY_LINES);
            $length = count($fp);

            while (($data = fgetcsv($csvFile, 0, ',', '"')) != FALSE) {
                if (!$firstline) {
                    //Progress
                    $percentage = round(($counter / $length) * 100, 2);
                    $txtPercentage = $percentage . "% (" . $counter . "/" . $length . ")";

                    $customer = ShipmentBlujay::where('load_id', $data['0'])->first();

                    if ($data['8'] == 'Voided') {
                        $deleteVoid = LoadPerformance::find($data['0']);
                        if ($deleteVoid != null) {
                            $deleteVoid->forceDelete();
                        }
                        error_log("Load Performance : " . $counter . " (VOID)", 0);
                    } else {
                        try {
                            LoadPerformance::create([
                                'tms_id' => $data['0'],
                                'created_date' => Carbon::createFromFormat('d/m/Y H:i', $data['1']),
                                'carrier_reference' => $data['2'],
                                'carrier_name' => $data['3'],
                                'equipment_description' => $data['4'],
                                'vehicle_number' => $data['5'],
                                'load_status' => $data['8'],
                                'first_pick_location_name' => $data['9'],
                                'last_drop_location_name' => $data['10'],
                                'routing_guide_name' => $data['61'] . '-' . $data['53'],
                                'payable_total_rate' => round(floatval(str_replace(',', '', $data['18'])), 2),
                                'billable_total_rate' => round(floatval(str_replace(',', '', $data['19'])), 2),
                                'closed_date' => ($this->checkDateString($data['20'])) ? Carbon::createFromFormat('d/m/Y H:i', $data['20']) : null,
                                'weight_lb' => round(floatval(str_replace(',', '', $data['24'])), 2),
                                'weight_kg' => round(floatval(str_replace(',', '', $data['25'])), 2),
                                'total_distance_km' => round(floatval(str_replace(',', '', $data['29'])), 2),
                                'load_group' => $data['47'],
                                'load_contact' => $data['48'],
                                'customer_name' => $customer == null ? '' : $customer->customer_name,
                                'customer_reference' => $customer == null ? '' : $customer->customer_reference,
                                'websettle_date' => ($this->checkDateString($data['22'])) ? Carbon::createFromFormat('d/m/Y H:i', $data['22']) : null,
                            ]);


                            error_log("Load Performance : " . $counter . " (New)", 0);
                        } catch (\Throwable $th) {
                            $exist = LoadPerformance::find($data['0']);

                            if (!is_null($exist)) {
                                $exist->forceDelete();
                            }

                            LoadPerformance::create([
                                'tms_id' => $data['0'],
                                'created_date' => Carbon::createFromFormat('d/m/Y H:i', $data['1']),
                                'carrier_reference' => $data['2'],
                                'carrier_name' => $data['3'],
                                'equipment_description' => $data['4'],
                                'vehicle_number' => $data['5'],
                                'load_status' => $data['8'],
                                'first_pick_location_name' => $data['9'],
                                'last_drop_location_name' => $data['10'],
                                'routing_guide_name' => $data['61'] . '-' . $data['53'],
                                'payable_total_rate' => round(floatval(str_replace(',', '', $data['18'])), 2),
                                'billable_total_rate' => round(floatval(str_replace(',', '', $data['19'])), 2),
                                'closed_date' => ($this->checkDateString($data['20'])) ? Carbon::createFromFormat('d/m/Y H:i', $data['20']) : null,
                                'weight_lb' => round(floatval(str_replace(',', '', $data['24'])), 2),
                                'weight_kg' => round(floatval(str_replace(',', '', $data['25'])), 2),
                                'total_distance_km' => round(floatval(str_replace(',', '', $data['29'])), 2),
                                'load_group' => $data['47'],
                                'load_contact' => $data['48'],
                                'customer_name' => $customer == null ? '' : $customer->customer_name,
                                'customer_reference' => $customer == null ? '' : $customer->customer_reference,
                                'websettle_date' => ($this->checkDateString($data['22'])) ? Carbon::createFromFormat('d/m/Y H:i', $data['22']) : null,
                            ]);

                            error_log("Load Performance : " . $counter . " (Exist Updating)", 0);
                        }
                    }

                    if ($counter % 100 == 0) {
                        echo "event: performance\n\n";
                        echo 'data: {"section":"(2/3) Performance", "percentage": "' . $txtPercentage . '", "total_complete": "' . rand(0, 9999) . '","total_data": "' . rand(0, 9999) . '"}' . "\n\n";

                        ob_flush();
                        flush();
                        if (connection_aborted()) {
                            break;
                        }
                    }
                    $counter++;
                }

                $firstline = false;
            }

            fclose($csvFile);


            //ADDCOST
            $csvFile = fopen(base_path("reference/local_blujay/RefreshAddcost.csv"), "r");

            $firstline = true;
            $checkedLoads = [];

            $counter = 1;

            //COUNT
            $fp = file(base_path("reference/local_blujay/RefreshAddcost.csv"), FILE_SKIP_EMPTY_LINES);
            $length = count($fp);

            while (($data = fgetcsv($csvFile, 0, ',', '"')) != FALSE) {
                error_log("Addcost : " . $counter, 0);

                //Progress
                $percentage = round(($counter / $length) * 100, 2);
                $txtPercentage = $percentage . "% (" . $counter . "/" . $length . ")";

                $counter++;
                if (!$firstline) {
                    //Check Duplicate Data
                    $isChecked = false;

                    foreach ($checkedLoads as $ch) {
                        if ($data['0'] == $ch) {
                            $isChecked = true;
                        }
                    }

                    if (!$isChecked) {
                        $existCheck = Addcost::where('load_id', '=', $data['0'])->get();

                        if (!is_null($existCheck)) {
                            foreach ($existCheck as $df) {
                                $df->forceDelete();
                            }
                        }

                        array_push($checkedLoads, $data['0']);
                    }
                    //END CHECK DUPLICATE DATA

                    Addcost::create([
                        'load_id' => $data['0'],
                        'rate' => round(floatval(str_replace(',', '', $data['2'])), 2),
                        'type' => $data['7'],
                    ]);

                    if ($counter % 100 == 0) {
                        echo "event: addcost\n\n";
                        echo 'data: {"section":"(3/3) Addcost", "percentage": "' . $txtPercentage . '", "total_complete": "' . rand(0, 9999) . '","total_data": "' . rand(0, 9999) . '"}' . "\n\n";

                        ob_flush();
                        flush();
                        if (connection_aborted()) {
                            break;
                        }
                    }
                }

                $firstline = false;
            }
            fclose($csvFile);

            //Close Connection
            echo "event: addcost\n\n";
            echo 'data: {"section":"done", "percentage": "' . $txtPercentage . '", "total_complete": "' . rand(0, 9999) . '","total_data": "' . rand(0, 9999) . '"}' . "\n\n";

            ob_flush();
            flush();

            sleep(3);
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
    }
}
