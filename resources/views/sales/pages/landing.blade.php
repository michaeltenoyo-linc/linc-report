@extends('sales.layouts.admin-layout')

@section('title')
Linc | Sales Report Homepage
@endsection

@section('header')
@include('sales.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <canvas id="chartRevenueYearly" width="100%" height="30%"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex flex-row-reverse">
        <div class="w-2/3 flex inline-block gap-4">
            <a href="/sales/by-sales/adit" class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white transform transition duration-500 hover:scale-110">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Sales
                                    </h5>
                                    <span class="font-semibold text-blueGray-700">
                                        Adit
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div
                                        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="text-orange-500 mr-2">
                                    <i class="fas fa-arrow-down"></i> 0.10%
                                </span>
                                <span class="whitespace-nowrap"> Since yesterday </span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
    
            <a href="/sales/by-sales/edwin" class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white transform transition duration-500 hover:scale-110">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Sales
                                    </h5>
                                    <span class="font-semibold text-blueGray-700">
                                        Edwin
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div
                                        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="text-orange-500 mr-2">
                                    <i class="fas fa-arrow-down"></i> 2.10%
                                </span>
                                <span class="whitespace-nowrap"> Since yesterday </span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
    
            <a href="/sales/by-sales/willem" class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white transform transition duration-500 hover:scale-110">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Sales
                                    </h5>
                                    <span class="font-semibold text-blueGray-700">
                                        Willem
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div
                                        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="text-orange-500 mr-2">
                                    <i class="fas fa-arrow-down"></i> 3.10%
                                </span>
                                <span class="whitespace-nowrap"> Since yesterday </span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="w-full flex">
        <div class="w-full flex inline-block gap-4">
            <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center mb-8">
                        <div class="flex-auto p-4">
                            <canvas id="chartBahanaMonthly" width="100%" height="30%"></canvas>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <a href="/sales/by-division/transport"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right">Division Unit Report</button></a>
                    </div>
                </div>
            </div>
    
            <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center mb-4">
                        <div class="flex-auto p-4">
                            <canvas id="chartTransportDaily" width="100%" height="35%"></canvas>
                        </div>
                        <div class="flex-auto p-4">
                            <canvas id="chartEximDaily" width="100%" height="30%"></canvas>
                        </div>
                    </div>
                    <div class="w-full p-4">
                        <div class="flex justify-between mb-1">
                            <span class="text-base font-medium text-blue-700 dark:text-white">Completed Order</span>
                            <span class="text-sm font-medium text-blue-700 dark:text-white">45%</span>
                        </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex">
        <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center mb-8">
                    <div class="w-2/3 p-4">
                        <canvas id="chartTransportMonthly" width="100%" height="40%"></canvas>
                    </div>
                    <div class="w-1/3 p-4">
                        <div class="font-bold text-xl">Transport</div> <br> 2.505/4.505 <br> 55.43%
                        <br>
                        <br>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right">Transport Log Pack</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex">
        <div class="w-full flex inline-block gap-4">
            <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center mb-8">
                        <div class="flex-auto p-4 w-1/2">
                            <canvas id="chartEximMonthly" width="100%" height="30%"></canvas>
                        </div>
                        <div class="flex-auto p-4 w-1/2">
                            <b>EXIM</b>
                            <br>
                            4.235/5.404
                            <br>
                            78.44%
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right">EXIM</button>
                    </div>
                </div>
            </div>
    
            <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center mb-8">
                        <div class="flex-auto p-4 w-1/2">
                            <canvas id="chartWarehouseMonthly" width="100%" height="30%"></canvas>
                        </div>
                        <div class="flex-auto p-4 w-1/2">
                            <b>Warehouse</b>
                            <br>
                            4.235/5.404
                            <br>
                            78.44%
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right">EXIM</button>
                    </div>
                </div>
            </div>

            <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center mb-8">
                        <div class="flex-auto p-4 w-1/2">
                            <canvas id="chartBulkMonthly" width="100%" height="30%"></canvas>
                        </div>
                        <div class="flex-auto p-4 w-1/2">
                            <b>Bulk</b>
                            <br>
                            4.235/5.404
                            <br>
                            78.44%
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right">EXIM</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
