@extends('sales.layouts.admin-layout')

@section('title')
Linc | Sales Performance
@endsection

@section('header')
@include('sales.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 overflow-x-auto break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="block w-full p-8 overflow-x-auto">
            <div class="w-full text-center font-bold text-xl mb-8">Sales Performance {{Str::ucfirst($sales)}}</div>

            <div class="inline-flex rounded-md shadow-sm mb-8">
                <a href="/sales/monitoring-master" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    Overall Achievement
                </a>
                <a href="/sales/by-sales/adit" aria-current="page" class="py-2 px-4 text-sm font-medium text-blue-700 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    By Sales Performance
                </a>
                <a href="/sales/by-division/transport" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    By Division Unit
                </a>
            </div>

            <div class="relative mb-8">
                <a href="/sales/by-sales/{{$sales}}" class="py-2 px-4 mx-2 text-sm font-medium bg-gray-100 text-blue-700">
                    {{$sales}}
                </a>
                @foreach ($sales_list as $s)
                    <a href="/sales/by-sales/{{$s}}" class="py-2 px-4 mx-2 text-sm font-medium text-gray-900 bg-white border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        {{$s}}
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
                    <div class="p-4 divisionPie" id="canvas-transport">
                        <canvas id="chartSalesTransport" width="100%" height="30%"></canvas>
                    </div>
                    <div class="p-4 divisionPie" id="canvas-exim">
                        <canvas id="chartSalesExim" width="100%" height="30%"></canvas>
                    </div>
                    <div class="p-4 divisionPie" id="canvas-bulk">
                        <canvas id="chartSalesBulk" width="100%" height="30%"></canvas>
                    </div>
                    <div class="p-4">
                        <canvas id="chartSalesWarehouse" width="100%" height="30%"></canvas>
                    </div>
                </div>
                <div class="w-full p-8">
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                        <span>Total Revenue (CM)</span>
                        <span class="text-right">IDR. <span id="sales-revenue-1m"></span></span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-600">
                        <span>Total Revenue (Ytd)</span>
                        <span class="text-right">IDR. <span id="sales-revenue-ytd"></span></span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                        <span>Total Loads (CM)</span>
                        <span class="text-right"><span id="sales-transaction-1m"></span> Load ID</span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-600">
                        <span>Total Loads (Ytd)</span>
                        <span class="text-right"><span id="sales-transaction-ytd"></span> Load ID</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-sky-500 dark:text-white">Achievement (CM)</span>
                        <span class="text-sm font-medium text-sky-500 dark:text-white"><span id="sales-achievement-1m"></span></span>
                    </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-sky-500 h-2.5 rounded-full" id="sales-achivementbar-1m"></div> <!-- Width achievement cm -->
                    </div>
                    <div class="flex justify-between mt-8">
                        <span class="text-base font-medium text-blue-700 dark:text-white">Achievement (Ytd.)</span>
                        <span class="text-sm font-medium text-blue-700 dark:text-white"><span id="sales-achievement-ytd"></span></span>
                    </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" id="sales-achivementbar-ytd"></div> <!-- Width achievement cm -->
                    </div>
                    <div class="w-full mt-8">
                        <canvas id="chartSalesRevenue" width="100%" height="30%"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="block w-full p-8 overflow-x-auto">
            <!-- Projects table -->
            <input type="hidden" name="salesName" id="sales-name" value="{{ $sales }}">
            <table id="yajra-datatable-sales-budget" style="width: 2000px;" class="items-center w-full bg-transparent border-collapse yajra-datatable-sales-budget">
            <thead>
                <tr>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Division
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
