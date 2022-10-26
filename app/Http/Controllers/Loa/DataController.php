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
use App\Models\LoaDetailBp;
use App\Models\LoaFile;
use App\Models\LoaMaster;
use App\Models\Priviledge;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Trucks;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class DataController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Navigation
    public function insert(Request $req)
    {
        if ($req->input('type') == 'cml') {
            $req->validate([
                'name' => 'required',
                'customer' => 'required',
                'type' => 'required',
                'effective' => 'required',
                'expired' => 'required',
                'filename' => 'required',
                'file' => 'required',
                'extension' => 'required',
                'rate_name' => 'required',
                'rate' => 'required',
                'qty' => 'required',
                'duration' => 'required',
            ]);
        } else if ($req->input('type') == 'bp') {
            $req->validate([
                'name' => 'required',
                'customer' => 'required',
                'type' => 'required',
                'effective' => 'required',
                'expired' => 'required',
                'filename' => 'required',
                'file' => 'required',
                'extension' => 'required',
            ]);
        }


        $checkCustomer = Customer::find($req->input('customer'));

        //File Check
        if ($req->hasFile('file') && $checkCustomer != null) {
            $filename = $req->input('customer') . '$' . $req->input('name') . '$' . $req->input('filename') . $req->input('extension');
            $req->file('file')->storeAs(
                'loa_files/' . $req->input('type'),
                $filename
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

            //Input Rate
            if ($req->input('type') == 'cml') {
                $rate_name = $req->input('rate_name');
                $rate = $req->input('rate');
                $qty = $req->input('qty');
                $duration = $req->input('duration');
                for ($i = 0; $i < $req->input('counter-rates') + 1; $i++) {
                    if (isset($rate_name[$i])) {
                        $costDetail = LoaDetail::create([
                            'name' => $rate_name[$i],
                            'id_loa' => $newLoa->id,
                            'cost' => $rate[$i],
                            'qty' => $qty[$i],
                            'duration' => $duration[$i],
                        ]);
                    }
                }
            } else if ($req->input('type') == 'bp') {
                //IF BP ADA EXCESS DeTAIL KOMPLEKS

                //RENTAL
                $ctr_rental = $req->input('counter-rental');
                if ($ctr_rental > -1) {
                    $rental_site = $req->input('rental_site');
                    $rental_type = $req->input('rental_type');
                    $rental_rate = $req->input('rental_rate');
                    $rental_qty = $req->input('rental_qty');
                    $rental_terms = $req->input('rental_terms');

                    for ($i = 0; $i < $req->input('counter-rental') + 1; $i++) {
                        if (isset($rental_site[$i])) {
                            $rentalDetail = LoaDetailBp::create([
                                'name' => 'rental|' . $rental_site[$i] . '|' . $rental_type[$i],
                                'id_loa' => $newLoa->id,
                                'cost' => $rental_rate[$i],
                                'uom' => $rental_qty[$i],
                                'terms' => $rental_terms[$i],
                                'type' => $rental_type[$i],
                            ]);
                        }
                    }
                }

                //EXCESS
                $ctr_excess = $req->input('counter-excess');
                if ($ctr_excess > -1) {
                    $excess_name = $req->input('excess_name');
                    $excess_type = $req->input('excess_type');
                    $excess_rate = $req->input('excess_rate');
                    $excess_qty = $req->input('excess_qty');
                    $excess_terms = $req->input('excess_terms');

                    for ($i = 0; $i < $req->input('counter-excess') + 1; $i++) {
                        if (isset($excess_name[$i])) {
                            $rentalDetail = LoaDetailBp::create([
                                'name' => 'excess|' . $excess_name[$i] . '|' . $excess_type[$i],
                                'id_loa' => $newLoa->id,
                                'cost' => $excess_rate[$i],
                                'uom' => $excess_qty[$i],
                                'terms' => $excess_terms[$i],
                                'type' => $excess_type[$i],
                            ]);
                        }
                    }
                }

                //ON CALL ROUTES
                $ctr_routes = $req->input('counter-routes');
                if ($ctr_routes > -1) {
                    $routes_type = $req->input('routes_type');
                    $routes_origin = $req->input('routes_origin');
                    $routes_destination = $req->input('routes_destination');
                    $routes_type = $req->input('routes_type');
                    $routes_rate = $req->input('routes_rate');

                    for ($i = 0; $i < $req->input('counter-routes') + 1; $i++) {
                        if (isset($routes_origin[$i])) {
                            $rentalDetail = LoaDetailBp::create([
                                'name' => 'routes|' . $routes_origin[$i] . '|' . $routes_destination[$i] . '|' . $routes_type[$i],
                                'id_loa' => $newLoa->id,
                                'cost' => $routes_rate[$i],
                                'uom' => 'routes',
                                'terms' => 'none',
                                'type' => $routes_type[$i],
                            ]);
                        }
                    }
                }

                //END COMPLEX EXCESS
            }


            return response()->json(['message' => "Berhasil menyimpan LOA baru."], 200);
        }

        return response()->json(['message' => "Terjadi kesalahan pada saat input."], 400);
    }

    //Navigation
    public function insertFile(Request $req)
    {
        $req->validate([
            'id_loa' => 'required',
            'filename' => 'required',
            'file' => 'required',
            'extension' => 'required'
        ]);

        $loa = LoaMaster::find($req->input('id_loa'));
        $checkCustomer = Customer::find($loa->id_customer);

        //File Check
        if ($req->hasFile('file') && $checkCustomer != null) {
            $filename = $checkCustomer->reference . '$' . $loa->name . '$' . $req->input('filename') . $req->input('extension');
            $req->file('file')->storeAs(
                'loa_files/' . $loa->type,
                $filename
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

    public function read(Request $req, $type)
    {
        $customerList = LoaMaster::where('type', $type)->get()->pluck('id_customer');
        $customerData = Customer::whereIn('reference', $customerList)->get();

        foreach ($customerData as $c) {
            $loa_list = LoaMaster::where('type', $type)
                ->where('id_customer', $c->reference)
                ->orderBy('effective', 'desc')
                ->get();

            $c->last_period = Carbon::parse($loa_list[0]->effective)->format('Y/m/d');
            $c->count = count($loa_list);
            $c->type = $type;
        }


        return DataTables::of($customerData)
            ->addColumn('action', function ($row) {
                $btn = '<a class="inline-flex" href="' . url('/loa/data/read/byCustomer/' . $row->type . '/' . $row->reference) . '"><button class="btn_yellow">Open</button></a>';
                return $btn;
            })
            ->make(true);
    }

    public function activationById($id)
    {
        $loa = LoaMaster::find($id);

        if ($loa->is_archived == 1) {
            $loa->is_archived = 0;
        } else if ($loa->is_archived == 0) {
            $loa->is_archived = 1;
        }

        $loa->save();
        return response()->json(['message' => "Berhasil melakukan aktif-nonaktif file"], 200);
    }

    public function pinById($id)
    {
        $loa = LoaMaster::find($id);

        if ($loa->is_pinned == 1) {
            $loa->is_pinned = 0;
        } else if ($loa->is_pinned == 0) {
            $loa->is_pinned = 1;
        }

        $loa->save();
        return response()->json(['message' => "Berhasil melakukan pin-unpin file"], 200);
    }

    public function readByCustomer($type, $reference)
    {
        //Admin Checking
        $data['isAdmin'] = 'false';
        $user = Auth::user();
        $data['type'] = $type;

        $userPriviledge = Priviledge::where('user_id', $user->id)->first();
        $priviledges = explode(';', $userPriviledge->priviledge);

        foreach ($priviledges as $p) {
            if ($p == "loa" || $p == 'master') {
                $data['isAdmin'] = 'true';
            }
        }


        $data['customer'] = Customer::find($reference);
        $data['loa'] = LoaMaster::where('id_customer', $reference)
            ->where('type', $type)
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
            $files = LoaFile::where('id_loa', $row->id)->get();
            $row->files = $files;
        }

        return view('loa.pages.list-loa-detail', $data);
    }

    public function getGroupByCustomer($type, $reference)
    {
        $customer = Customer::find($reference);
        $data['groups'] = LoaMaster::select('group')
            ->where('type', $type)
            ->where('id_customer', $reference)
            ->groupBy('group')
            ->get()->pluck('group')->toArray();

        $pinnedExist = LoaMaster::where('is_pinned', 1)->where('id_customer', $reference)->where('type', $type)->get();


        if (count($pinnedExist) > 0) {
            array_unshift($data['groups'], "Favorite");
        }

        return $data;
    }

    public function getTimelineByGroup($type, $reference, $group)
    {
        $customer = Customer::find($reference);

        $data['timeline'] = LoaMaster::where('type', $type)
            ->where('id_customer', $reference)
            ->where('group', $group)
            ->orderBy('effective', 'desc')
            ->get();

        return $data;
    }

    public function getRatesByLoa($loa_id, $type)
    {
        $data['rates'] = $type == 'cml' ? LoaDetail::where('id_loa', $loa_id)->get() : LoaDetailBp::where('id_loa', $loa_id)->get();
        return response()->json($data, 200);
    }

    public function getFileByGroup($group)
    {
        $files = LoaFile::where('id_loa', $group)->get();

        return $files;
    }

    public function getFileById($id)
    {
        $file = LoaFile::find($id);

        $file->content_path = LoaMaster::find($file->id_loa);

        return $file;
    }

    public function readById($id)
    {
        $data['loa'] = LoaMaster::find($id);

        return response()->json($data, 200);
    }

    public function deleteById($id)
    {
        $loa = LoaMaster::find($id);
        $type = $loa->type;
        $loa->forceDelete();

        //Delete Files
        $loa_files = LoaFile::where('id_loa', $id)->get();

        foreach ($loa_files as $file) {
            Storage::delete('loa_files/' . $type . '/' . $file->filename);
            $file->forceDelete();
        }

        //Delete Details
        $loa_details = LoaDetail::where('id_loa', $id)->get();

        foreach ($loa_details as $detail) {
            $detail->delete();
        }

        return response(['message' => 'Berhasil menghapus data'], 200);
    }

    public function deleteFileById($id)
    {
        $file = LoaFile::find($id);
        $loa = LoaMaster::find($file->id_loa);

        Storage::delete('loa_files/' . $loa->type . '/' . $file->filename);
        $file->forceDelete();

        return response(['message' => 'Berhasil menghapus file'], 200);
    }

    public function getPinnedLoa($type, $reference)
    {
        $customer = Customer::find($reference);

        $data['timeline'] = LoaMaster::where('type', $type)
            ->where('id_customer', $reference)
            ->where('is_pinned', 1)
            ->orderBy('effective', 'desc')
            ->get();

        return $data;
    }

    public function editDetailByLoa(Request $req, $id_loa)
    {
        $req->validate([
            'name' => 'required',
            'cost' => 'required',
            'qty' => 'required',
            'duration' => 'required',
        ]);

        $data['message'] = "Success";

        //Update Data
        $loa_detail = LoaDetail::where('id_loa', $id_loa)->where('name', $req->input('name'))->first();

        $loa_detail->update([
            'cost' => $req->input('cost'),
            'qty' => $req->input('qty'),
            'duration' => $req->input('duration'),
        ]);

        return response()->json($data, 200);
    }

    public function deleteDetailByLoa(Request $req, $id_loa)
    {
        $req->validate([
            'name' => 'required',
        ]);

        $data['message'] = "Success";

        //Update Data
        $loa_detail = LoaDetail::where('id_loa', $id_loa)->where('name', $req->input('name'))->first();
        $loa_detail->forceDelete();

        return response()->json($data, 200);
    }

    public function insertDetailByLoa(Request $req, $id_loa)
    {
        $req->validate([
            'rate_name' => 'required',
            'rate' => 'required',
            'qty' => 'required',
            'duration' => 'required',
        ]);

        $ctr = $req->input('counter-rates');
        $name = $req->input('rate_name');
        $rate = $req->input('rate');
        $qty = $req->input('qty');
        $duration = $req->input('duration');

        for ($i = 0; $i <= $ctr; $i++) {
            if (isset($name[$i])) {
                LoaDetail::create([
                    'id_loa' => $id_loa,
                    'name' => $name[$i],
                    'cost' => $rate[$i],
                    'qty' => $qty[$i],
                    'duration' => $duration[$i]
                ]);
            }
        }

        $data['message'] = "Berhasil menambah data rate";
        return response()->json($data, 200);
    }
}
