<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Item;
use App\Models\Trucks;
use App\Models\Suratjalan;

class TruckController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkTruck(Request $req, $nopol){
        $temp = Trucks::where('nopol','=',$nopol)->first();

        $data['check'] = false;
        $data['message'] = "Kendaraan tidak terdaftar.";

        if($temp != null){
            if($temp->taken == 0){
                $data['check'] = false;
                $data['kategori'] = $temp->kategori;
                $data['message'] = "Kendaraan tidak valid (TIDAK DIAMBIL).";
            }else{
                $data['check'] = true;
                $data['kategori'] = $temp->kategori;
                $data['message'] = "Kendaraan ditemukan.";
            }
            
        }

        return response()->json($data,200);
    }

    public function delete(Request $req){
        $sj = Trucks::where('nopol','=',$req->input('nopol'))->first();
        $sj->delete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }
    
}
