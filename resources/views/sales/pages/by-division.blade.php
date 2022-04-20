@extends('sales.layouts.admin-layout')

@section('title')
Linc | Sales Monitoring
@endsection

@section('header')
@include('sales.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="" value="ByDivision" id="page-content">
    <div class="relative flex flex-col min-w-0 overflow-x-auto break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="block w-full p-8 overflow-x-auto">
            <div class="w-full text-center font-bold text-xl mb-8">Division Unit {{Str::ucfirst($division)}}</div>

            <div class="inline-flex rounded-md shadow-sm mb-8">
                <a href="/sales/monitoring-master" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    Overall Achievement
                </a>
                <a href="/sales/by-sales/adit" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    By Sales Performance
                </a>
                <a href="/sales/by-division/transport" aria-current="page" class="py-2 px-4 text-sm font-medium text-blue-700 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    By Division Unit
                </a>
            </div>

            <div class="relative mb-8">
                <a href="/sales/by-division/{{$division}}" class="py-2 px-4 mx-2 text-sm font-medium bg-gray-100 text-blue-700">
                    {{$division}}
                </a>
                @foreach ($division_list as $d)
                    <a href="/sales/by-division/{{$d}}" class="py-2 px-4 mx-2 text-sm font-medium text-gray-900 bg-white border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        {{$d}}
                    </a>
                @endforeach
            </div>

            <div class="w-full mb-8">
                <form id="form-items-new" autocomplete="off">
                    <div class="relative">
                        <input
                            type="month"
                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            id="date-filter"
                            >
                    </div>
                </form>
            </div>
            <div class="w-full"><hr></div>

            <!-- Chart Overview -->
            <div class="w-full my-4 p-8 inline-grid grid-cols-2">
                <div class="w-full p-4 inline-grid grid-cols-2">
                    <div class="w-full p-4 salesPie" id="canvas-adit">
                        <canvas id="chartDivisionAdit" width="100%" height="30%"></canvas>
                    </div>
                    <div class="w-full p-4 salesPie" id="canvas-edwin">
                        <canvas id="chartDivisionEdwin" width="100%" height="30%"></canvas>
                    </div>
                    <div class="w-full p-4 salesPie" id="canvas-willem">
                        <canvas id="chartDivisionWillem" width="100%" height="30%"></canvas>
                    </div>
                    <div class="w-full p-4 salesPie" id="canvas-unlocated">
                        <canvas id="chartDivisionUnlocated" width="100%" height="30%"></canvas>
                    </div>
                </div>
                <div class="w-full p-8">
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                        <span>Total Revenue (CM)</span>
                        <span class="text-right">IDR. <span id="division-revenue-1m"></span></span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-600">
                        <span>Total Revenue (Ytd)</span>
                        <span class="text-right">IDR. <span id="division-revenue-ytd"></span></span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                        <span>Total Loads (CM)</span>
                        <span class="text-right"><span id="division-transaction-1m"></span> Load ID's</span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-600">
                        <span>Total Loads (Ytd)</span>
                        <span class="text-right"><span id="division-transaction-ytd"></span> Load ID's</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-sky-500 dark:text-white">Achievement (CM)</span>
                        <span class="text-sm font-medium text-sky-500 dark:text-white"><span id="division-achievement-1m"></span></span>
                    </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-sky-500 h-2.5 rounded-full" id="division-achivementbar-1m"></div>
                    </div>
                    <div class="flex justify-between mt-8">
                        <span class="text-base font-medium text-blue-700 dark:text-white">Achievement (Ytd.)</span>
                        <span class="text-sm font-medium text-blue-700 dark:text-white"><span id="division-achievement-ytd"></span></span>
                    </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" id="division-achivementbar-ytd"></div>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-1 text-lg font-bold text-blue-600 mt-8">
                        <span>Unlocated Customers</span>
                        <span class="text-sky-500"><span id="unlocated-division-customers"></span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="block w-full p-8 overflow-x-auto">
            <input type="hidden" name="division" id="division-name" value="{{ $division }}">
            <!-- Projects table -->
            <table id="yajra-datatable-division-budget" style="width: 2500px;" class="items-center w-full bg-transparent border-collapse yajra-datatable-division-budget">
            <thead>
                <tr>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Sales
                </th>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Customer
                </th>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Status
                </th>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Period
                </th>
                <th style="width: 250px;" class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Achievement (1m)
                </th>
                <th style="" class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Achievement (ytd)
                </th>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Graph
                </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
