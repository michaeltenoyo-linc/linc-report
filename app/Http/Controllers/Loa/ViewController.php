<?php

namespace App\Http\Controllers\Loa;

use App\Models\District;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\BillableBlujay;
use App\Models\Customer;
use App\Models\dloa_transport;
use App\Models\Loa_transport;
use App\Models\Loa_warehouse;
use App\Models\LoaDetail;
use App\Models\LoaMaster;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Trucks;
use App\Models\TruckType;
use App\Models\Village;
use Carbon\Carbon;

class ViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function gotoLandingPage()
    {
        return view('loa.pages.landing');
    }

    public function gotoInputType()
    {
        return view('loa.pages.input-loa-type');
    }

    public function gotoInputForm($type)
    {
        $data['type'] = $type;
        $data['customer'] = Customer::get();
        $data['group_list'] = LoaMaster::join('customers', 'customers.reference', '=', 'loa_masters.id_customer')
            ->select('customers.name', 'loa_masters.group')
            ->groupBy('customers.name', 'loa_masters.group')
            ->get();
        //return $data;


        if ($type == 'bp') {
            //INPUT AUTOCOMPLETE
            $data['vehicle_type'] = TruckType::get();
            $province = Province::all();
            //$regencies = Regency::all();
            //$districts = District::all();
            //$villages = Village::all();

            $data['regions'] = [];

            foreach ($province as $p) {
                array_push($data['regions'], $p->name);
                foreach ($p->regencies as $r) {
                    array_push($data['regions'], $p->name . ',' . $r->name);
                    foreach ($r->districts as $d) {
                        array_push($data['regions'], $p->name . ',' . $r->name . ',' . $d->name);
                    }
                }
            }
        }

        return view('loa.pages.input-loa-form', $data);
    }

    public function gotoListType()
    {
        return view('loa.pages.list-loa-type');
    }

    public function gotoListMaster($type)
    {
        $data['type_raw'] = $type;
        switch ($type) {
            case 'bp':
                $data['type'] = "Bahana Prestasi";
                break;
            case 'cml':
                $data['type'] = "Cipta Mapan Logistik";
                break;
        }
        return view('loa.pages.list-loa-master', $data);
    }

    public function gotoReportGenerate()
    {
        return view('loa.pages.loa-report-generate');
    }

    public function generateReport(Request $req, $division, $showArchive, $customer)
    {
        $isArchived = $showArchive == 'true' ? 1 : 0;

        $loa_list = LoaMaster::where('type', $division)
            ->where('is_archived', $isArchived)
            ->where('id_customer', 'LIKE', $customer == 'all' ? '%%' : $customer)
            ->get();

        foreach ($loa_list as $loa) {
            $detail = LoaDetail::where('id_loa', $loa->id)->get();
            $loa->detail = $detail;
        }

        return response($loa_list, 200);
    }
}
