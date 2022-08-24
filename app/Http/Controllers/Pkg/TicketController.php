<?php

namespace App\Http\Controllers\Pkg;

use App\Models\dsuratjalan_pkg;
use App\Models\Suratjalan_pkg;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model

class TicketController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getTicket(Request $req){
        $data = Suratjalan_pkg::get();

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $btn = '<button class="btn_yellow" id="btn-detail-ticket" value="'.$row->posto.'">Detail</button>';
                $btn = $btn.'<form id="btn-ticket-delete" class="inline-flex"><input name="posto" type="hidden" value="'.$row->posto.'"><button type="submit" class="btn_red">Delete</button></form>';
                return $btn;
            })
            ->make(true);
    }

    public function delete(Request $req){
        $ticket = Suratjalan_pkg::where('posto','=',$req->input('posto'))->first();
        $dload = dsuratjalan_pkg::where('posto','=',$req->input('posto'))->get();

        foreach ($dload as $r) {
            $r->forceDelete();
        }
        $ticket->forceDelete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }

    public function checkPosto(Request $req, $posto){
        $data['message'] = "ID Posto belum terdaftar";
        $data['check'] = true;

        $checkPosto = Suratjalan_pkg::find($posto);

        if($checkPosto){
            $data['posto'] = $checkPosto;
            $data['check'] = false;
        }

        return response()->json($data, 200);
    }

    public function addPosto(Request $req){
        $data['message'] = "Berhasil menambah POSTO baru.";

        Suratjalan_pkg::create([
            'posto' => $req->input('posto'),
            'qty' => $req->input('qty'),
            'terbit' => $req->input('terbit'),
            'expired' => $req->input('expired'),
            'produk' => $req->input('produk'),
            'tujuan' => $req->input('tujuan'),
        ]);

        return response()->json($data, 200);
    }

    public function checkLoad(Request $req, $load){
        $data['message'] = "Load ID belum terdaftar";
        $data['check'] = true;

        $checkLoad = dsuratjalan_pkg::find($load);

        if($checkLoad){
            $data['load'] = $checkLoad;
            $data['check'] = false;
        }

        return response()->json($data, 200);
    }

    public function addLoads(Request $req){
        $req->validate([
            'loads' => 'required',
            'bookings' => 'required',
            'posto' => 'required',
            'counter' => 'required',
        ]);

        $data['message'] = "Berhasil menambah Loads baru.";
        $data['error'] = [];
        $loads = $req->input('loads');
        $bookings = $req->input('bookings');
        //Create 
        for ($i=0; $i < $req->input('counter') ; $i++) { 
            try {
                if(isset($loads[$i]) && isset($bookings[$i])){
                    dsuratjalan_pkg::create([
                        'load_id' => $loads[$i],
                        'posto' => $req->input('posto'),
                        'booking_code' => $bookings[$i],
                    ]);
                }
            } catch (\Throwable $th) {
                array_push($data['error'], $loads[$i]);
            }
        }

        return response()->json($data, 200);
    }
}
