@extends('sales.layouts.admin-layout')

@section('title')
Linc | Overall Achievement
@endsection

@section('header')
@include('sales.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="" value="masterMonitoring" id="page-content">
    <div class="relative flex flex-col min-w-0 overflow-x-auto break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="block w-full p-8 overflow-x-auto">
            <div class="w-full text-center font-bold text-xl mb-8">Overall Achievement Master</div>
            
            <div class="inline-flex rounded-md shadow-sm mb-8">
                <a href="/sales/monitoring-master" aria-current="page" class="py-2 px-4 text-sm font-medium text-blue-700 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                  Overall Achievement
                </a>
                <a href="/sales/by-sales/adit" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                  By Sales Performance
                </a>
                <a href="/sales/by-division/transport" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                  By Division Unit
                </a>
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
        </div>
        <div class="block w-full p-8 overflow-x-auto">
            <!-- Projects table -->
            <table id="yajra-datatable-monitoring-budget" style="width: 2000px;" class="items-center w-full bg-transparent border-collapse yajra-datatable-monitoring-budget">
            <thead>
                <tr>
                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                    Sales
                </th>
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
