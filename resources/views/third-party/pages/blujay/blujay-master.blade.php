@extends('third-party.layouts.admin-layout')

@section('title')
Linc | Blujay Refresh
@endsection

@section('header')
@include('third-party.components.header_no_login')
@endsection

@section('content')
<input type="hidden" id="page-context" name="page-context" value="blujay">
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <!-- Third Party Icon -->
            <div class="flex flex-wrap items-center">
                <div class="flex w-full h-24 px-4 max-w-full justify-center">
                    <img class="object-contain" src="{{ asset('assets/logos/blujay.png') }}" alt="">
                </div>
            </div>

            <div class="w-full grid grid-cols-3 gap-4 my-5">
                <button onclick="location.href='{{ url('/third-party/blujay/refresh') }}'" class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5">
                    <div class="w-full">
                        <i class="fas fa-sync text-8xl mb-5"></i>
                        <br>
                        <b class="text-lg">Refresh Data</b>
                        <br>
                        Last : {{ $latest->created_at }}
                    </div>
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5">
                    <div class="w-full">
                        <i class="fas fa-database text-8xl mb-5"></i>
                        <br>
                        <b class="text-lg">Stream Data Synchronization</b>
                    </div>
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5">
                    <div class="w-full">
                        <i class="fas fa-tools text-8xl mb-5"></i>
                        <br>
                        <b class="text-lg">None</b>
                    </div>
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5">
                    <div class="w-full">
                        <i class="fas fa-users text-8xl mb-5"></i>
                        <br>
                        <b class="text-lg">Customer</b>
                    </div>
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5">
                    <div class="w-full">
                        <i class="fas fa-boxes text-8xl mb-5"></i>
                        <br>
                        <b class="text-lg">Load</b>
                    </div>
                </button>
                <button class="bg-teal-200 hover:bg-teal-300 rounded text-center justify-center p-5">
                    <div class="w-full">
                        <i class="fas fa-passport text-8xl mb-5"></i>
                        <br>
                        <b class="text-lg">TMS Webpage</b>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
