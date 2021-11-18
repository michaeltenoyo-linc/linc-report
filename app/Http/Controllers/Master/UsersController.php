<?php

namespace App\Http\Controllers\Master;

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
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //User onLogin
    public function onLogin(Request $req)
    {
        $credentials =  $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $req->session()->regenerate();

            return response()->json(['message' => 'Berhasil login'],200);
        }

        return response()->json(['message' => 'Gagal login'],400);
    }

    public function onLogout(Request $req){
        if(Auth::check()){
            Auth::logout();

            return response()->json(['message' => "Berhasil logout."], 200);
        }else{
            return response()->json(["message" => "User tidak login saat ini."], 400);
        }
    }
}
