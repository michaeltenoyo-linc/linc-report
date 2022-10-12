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
use App\Models\LoaMaster;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Trucks;
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
}
