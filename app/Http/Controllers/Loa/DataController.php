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
use App\Models\LoaFile;
use App\Models\LoaMaster;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Trucks;
use App\Models\Village;
use Carbon\Carbon;

class DataController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function insert(Request $req){
        $req->validate([
            'name' => 'required',
            'customer' => 'required',
            'type' => 'required',
            'effective' => 'required',
            'expired' => 'required',
            'filename' => 'required',
            'file' => 'required',
            'extension' => 'required'
        ]);

        $checkCustomer = Customer::find($req->input('customer'));

        //File Check
        if($req->hasFile('file') && $checkCustomer != null){
            $filename = $req->input('customer').'-'.$req->input('filename').$req->input('extension');
            $req->file('file')->storeAs(
                'loa_files/'.$req->input('type'), $filename
            );

            //Input To Database
            $newLoa = LoaMaster::create([
                'name' => $req->input('name'),
                'effective' => $req->input('effective'),
                'expired' => $req->input('expired'),
                'id_customer' => $req->input('customer'),
                'type' => $req->input('type')
            ]);

            $newFile = LoaFile::create([
                'id_loa' => $newLoa->id,
                'filename' => $filename,
                'extension' => $req->input('extension'),
            ]);

            return response()->json(['message' => "Berhasil menyimpan LOA baru."], 200);
        }

        return response()->json(['message' => "Terjadi kesalahan pada saat input."], 400);
    }

    public function read(Request $req, $type){
        $customerList = LoaMaster::where('type',$type)->get()->pluck('id_customer');
        $customerData = Customer::whereIn('reference',$customerList)->get();

        foreach ($customerData as $c) {
            $loa_list = LoaMaster::where('type',$type)
                                ->where('id_customer',$c->reference)
                                ->orderBy('expired','desc')
                                ->get();
            
            $c->last_period = $loa_list[0]->expired;      
            $c->count = count($loa_list);
            $c->type = $type;
        }


        return DataTables::of($customerData)
                        ->addColumn('action', function($row){
                            $btn = '<a class="inline-flex" href="'.url('/loa/data/read/byCustomer/'.$row->type.'/'.$row->reference).'"><button class="btn_yellow">Open</button></a>';
                            return $btn;
                        })
                        ->make(true);
    }

    public function readByCustomer($type, $reference){
        $data['customer'] = Customer::find($reference);
        $data['loa'] = LoaMaster::where('id_customer',$reference)
                                ->where('type',$type)
                                ->get();
                                
        $data['customer']->type = $type;
        switch ($type) {
            case 'bp':
                $data['customer']->type_full = "Bahana Prestasi";
                break;
            case 'cml':
                $data['customer']->type_full = "Cipta Mapan Logistik";
                break;
        }

        foreach ($data['loa'] as $row) {
            $files = LoaFile::where('id_loa',$row->id)->get();
            $row->files = $files;
        }

        return view('loa.pages.list-loa-detail', $data);
    }
}
