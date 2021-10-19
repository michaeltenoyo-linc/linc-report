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

    public function Create(Request $req){
        $req->validate([
            'nopol' => 'required',
            'fungsional' => 'required',
            'ownership' => 'required',
            'owner' => 'required',
            'type' => 'required',
            'v_gps' => 'required',
            'site' => 'required',
            'area' => 'required',
            'pengambilan' => 'required',
            'kategori' => 'required',
        ]);

        $newTruck = Trucks::create([
            'nopol' => $req->input('nopol'),
            'fungsional' => $req->input('fungsional'),
            'ownership' => $req->input('ownership'),
            'owner' => $req->input('owner'),
            'type' => $req->input('type'),
            'v_gps' => $req->input('v_gps'),
            'site' => $req->input('site'),
            'area' => $req->input('area'),
            'taken' => $req->input('pengambilan'),
            'kategori' => $req->input('kategori')
        ]);        

        return response()->json(['message' => "Data berhasil disimpan."], 200);
    }

    public function delete(Request $req){
        $sj = Trucks::where('nopol','=',$req->input('nopol'))->first();
        $sj->delete();

        return response()->json(['message' => 'berhasil menghapus data.'], 200);
    }
    
}
