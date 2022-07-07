@extends('third-party.layouts.admin-layout')

@section('title')
Linc | Third Party Homepage
@endsection

@section('header')
@include('third-party.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700 text-center">
                        Choose which platform do you want to access
                    </h3>
                </div>
            </div>

            <div class="w-full grid grid-cols-4 gap-4 my-5">
                <button onclick="location.href='{{ url('/third-party/blujay') }}'" class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5 font-bold">
                    <img src="{{ asset('assets/logos/blujay.png') }}" alt="">
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5 font-bold">
                    GSoft
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5 font-bold">
                    Flask
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5 font-bold">
                    <img src="{{ asset('assets/logos/SAP.png') }}" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
