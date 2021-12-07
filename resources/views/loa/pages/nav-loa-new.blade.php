@extends('loa.layouts.admin-layout')

@section('title')
Linc | Input LOA
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Letter of Agreement
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <div class="flex flex-nowrap p-8 ">
                <div class="flex flex-wrap w-full">
                    <div class="w-1/2 mb-3">
                        <button onclick="window.location='{{ url('/loa/action/warehouse/nav-insert') }}'" id="btn-new-warehouse" class="w-3/4 bg-blue-500 text-white font-bold py-10 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            Warehouse
                        </button>
                    </div>
                    <div class="w-1/2 mb-3">
                        <button id="btn-new-bulk" class="w-3/4 bg-blue-500 text-white font-bold py-10 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            Bulk
                        </button>
                    </div>
                    <div class="w-1/2 mb-3">
                        <button onclick="window.location='{{ url('/loa/action/transport/nav-insert') }}'" id="btn-new-warehouse" class="w-3/4 bg-blue-500 text-white font-bold py-10 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            Transport
                        </button>
                    </div>
                    <div class="w-1/2 mb-3">
                        <button id="btn-new-exim" class="w-3/4 bg-blue-500 text-white font-bold py-10 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            EXIM
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
