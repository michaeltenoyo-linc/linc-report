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
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input datepicker datepicker-autohide datepicker-format="mm/yyyy" value="{{date('m/Y')}}" datepicker-title="Period Filter" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                    </div>
                </form>
            </div>
            <div class="w-full"><hr></div>

            <!-- Chart Overview -->
            <div class="w-full my-4 p-8 inline-grid grid-cols-2">
                <div class="w-full p-4 inline-grid grid-cols-2">
                    <div class="p-4">
                        <canvas id="chartSalesTransport" width="100%" height="30%"></canvas>
                    </div>
                    <div class="p-4">
                        <canvas id="chartSalesExim" width="100%" height="30%"></canvas>
                    </div>
                    <div class="p-4">
                        <canvas id="chartSalesBulk" width="100%" height="30%"></canvas>
                    </div>
                    <div class="p-4">
                        <canvas id="chartSalesWarehouse" width="100%" height="30%"></canvas>
                    </div>
                </div>
                <div class="w-full p-8">
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                        <span>Total Revenue (1M)</span>
                        <span class="text-right">IDR. {{ number_format($revenue_1m->totalActual, 2, ',', '.') }}</span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-600">
                        <span>Total Revenue (Ytd)</span>
                        <span class="text-right">IDR. {{ number_format($revenue_ytd, 2, ',', '.') }}</span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                        <span>Total Transaction (1M)</span>
                        <span class="text-right">{{ number_format($transaction_1m->totalTransaction, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-600">
                        <span>Total Transaction (Ytd)</span>
                        <span class="text-right">{{ number_format($transaction_ytd, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-sky-500 dark:text-white">Achievement (1M)</span>
                        <span class="text-sm font-medium text-sky-500 dark:text-white">({{ round($revenue_1m->totalActual/1000000,0) }}/{{ round($budget_1m->totalBudget/1000000,0) }} Mill.) {{ $achivement_1m }}%</span>
                    </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-sky-500 h-2.5 rounded-full" style="width: {{ $achivement_1m }}%"></div>
                    </div>
                    <div class="flex justify-between mt-8">
                        <span class="text-base font-medium text-blue-700 dark:text-white">Achievement (Ytd.)</span>
                        <span class="text-sm font-medium text-blue-700 dark:text-white">({{ round($revenue_ytd/1000000,0) }}/{{ round($budget_ytd/1000000,0) }} Mill.) {{ $achivement_ytd }}%</span>
                    </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $achivement_ytd }}%"></div>
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
