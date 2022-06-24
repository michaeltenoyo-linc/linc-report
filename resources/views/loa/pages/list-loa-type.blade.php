@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="w-full p-10 text-center">
            <h1 class="font-bold text-2xl">List Letter of Agreement</h1>
            <h5>Pilih Tipe LOA</h5>
        </div>
        <div class="lg:w-full md:w-full grid grid-cols-2 gap-4 content-center">
            <div class="w-full text-center p-10">
                <button onclick="window.location='{{ url("/loa/nav-loa-list/bp") }}'" class="h-72 w-full rounded-full bg-red-700 hover:bg-red-500 text-white text-2xl font-bold">
                    Bahana<br>Prestasi
                </button>
            </div>
            <div class="w-full text-center p-10">
                <button onclick="window.location='{{ url("/loa/nav-loa-list/cml") }}'" class="h-72 w-full rounded-full bg-red-700 hover:bg-red-500 text-white text-2xl font-bold">
                    Cipta<br>Mapan<br>Logistik
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
