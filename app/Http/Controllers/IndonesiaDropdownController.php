<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

//Model
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class IndonesiaDropdownController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function provinces()
    {
        return Province::get();
    }

    public function cities(Request $request, $id)
    {
        return Regency::where('province_id',$id)->pluck('name','id');
    }

    public function districts(Request $request, $id)
    {
        return District::where('regency_id',$id)->pluck('name','id');
    }

    public function villages(Request $request, $id)
    {
        return Village::where('district_id',$id)->get();
    }
}
