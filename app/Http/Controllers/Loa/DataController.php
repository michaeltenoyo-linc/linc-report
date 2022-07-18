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
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

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
            $filename = $req->input('customer').'$'.$req->input('name').'$'.$req->input('filename').$req->input('extension');
            $req->file('file')->storeAs(
                'loa_files/'.$req->input('type'), $filename
            );

            //Input To Database
            $newLoa = LoaMaster::create([
                'name' => $req->input('name'),
                'effective' => $req->input('effective'),
                'expired' => $req->input('expired'),
                'is_archived' => 0,
                'is_pinned' => 1,
                'id_customer' => $req->input('customer'),
                'type' => $req->input('type'),
                'group' => $req->input('group')
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

    //Navigation
    public function insertFile(Request $req){
        $req->validate([
            'id_loa' => 'required',
            'filename' => 'required',
            'file' => 'required',
            'extension' => 'required'
        ]);

        $loa = LoaMaster::find($req->input('id_loa'));
        $checkCustomer = Customer::find($loa->id_customer);

        //File Check
        if($req->hasFile('file') && $checkCustomer != null){
            $filename = $checkCustomer->reference.'$'.$loa->name.'$'.$req->input('filename').$req->input('extension');
            $req->file('file')->storeAs(
                'loa_files/'.$loa->type, $filename
            );

            $newFile = LoaFile::create([
                'id_loa' => $loa->id,
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
                                ->orderBy('effective','desc')
                                ->get();
            
            $c->last_period = Carbon::parse($loa_list[0]->effective)->format('Y/m/d');      
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

    public function activationById($id){
        $loa = LoaMaster::find($id);

        if($loa->is_archived == 1){
            $loa->is_archived = 0;
        }else if($loa->is_archived == 0){
            $loa->is_archived = 1;
        }

        $loa->save();
        return response()->json(['message' => "Berhasil melakukan aktif-nonaktif file"], 200);
    }

    public function pinById($id){
        $loa = LoaMaster::find($id);

        if($loa->is_pinned == 1){
            $loa->is_pinned = 0;
        }else if($loa->is_pinned == 0){
            $loa->is_pinned = 1;
        }

        $loa->save();
        return response()->json(['message' => "Berhasil melakukan pin-unpin file"], 200);
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

    public function getGroupByCustomer($type, $reference){
        $customer = Customer::find($reference);
        $data['groups'] = LoaMaster::select('group')
                                    ->where('type',$type)
                                    ->where('id_customer',$reference)
                                    ->groupBy('group')
                                    ->get()->pluck('group')->toArray();

        $pinnedExist = LoaMaster::where('is_pinned',1)->where('id_customer',$reference)->where('type',$type)->get();


        if(count($pinnedExist) > 0){
            array_unshift($data['groups'], "Favorite");
        }

        return $data;
    }

    public function getTimelineByGroup($type, $reference, $group){
        $customer = Customer::find($reference);

        $data['timeline'] = LoaMaster::where('type',$type)
                                    ->where('id_customer',$reference)
                                    ->where('group', $group)
                                    ->orderBy('effective','desc')
                                    ->get();
                                    
        return $data;
    }

    public function getFileByGroup($group){
        $files = LoaFile::where('id_loa',$group)->get();
        
        return $files;
    }

    public function getFileById($id){
        $file = LoaFile::find($id);

        $file->content_path = LoaMaster::find($file->id_loa);

        return $file;
    }

    public function readById($id){
        $data['loa'] = LoaMaster::find($id);

        return response()->json($data, 200);
    }

    public function deleteById($id){
        $loa = LoaMaster::find($id);
        $type = $loa->type;
        $loa->forceDelete();

        $loa_files = LoaFile::where('id_loa',$id)->get();

        foreach ($loa_files as $file) {
            Storage::delete('loa_files/'.$type.'/'.$file->filename);
            $file->forceDelete();
        }

        return response(['message' => 'Berhasil menghapus data'], 200);
    }

    public function deleteFileById($id){
        $file = LoaFile::find($id);
        $loa = LoaMaster::find($file->id_loa);
        
        Storage::delete('loa_files/'.$loa->type.'/'.$file->filename);
        $file->forceDelete();

        return response(['message' => 'Berhasil menghapus file'], 200);
    }

    public function getPinnedLoa($type, $reference){
        $customer = Customer::find($reference);

        $data['timeline'] = LoaMaster::where('type',$type)
                                    ->where('id_customer',$reference)
                                    ->where('is_pinned', 1)
                                    ->orderBy('effective','desc')
                                    ->get();
                                    
        return $data;
    }
}
