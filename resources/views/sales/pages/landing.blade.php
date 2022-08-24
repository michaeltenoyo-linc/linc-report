@extends('sales.layouts.admin-layout')

@section('title')
Linc | Sales Report Homepage
@endsection

@section('header')
@include('sales.components.header_no_login')
<!-- Styles -->	
<style>
    marquee {
        margin: 0 auto;
        overflow: hidden;
        white-space: nowrap;
    }

    @keyframes marquee {
        0%   { left: 100%; }
        100% { left: -100%; }
    }
</style>
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="" value="landing" id="page-content">
    
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-1/2 px-4 py-3 flex-grow flex-1 text-red-600 font-bold">
                    <input 
                        type="month" 
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        id="date-filter-landing"
                        >
                </div>
                <div class="relative w-1/2 px-4 flex-grow flex-1 text-red-600 font-bold">
                    Last Update : {{ $last_update->updated_at }}
                </div>
            </div>
        </div>
    </div>

    <!-- SALES CARD 

        <img src="{{ asset('assets/novena/images/sales-card-background.png') }}"/>

    -->


    @if ($isSales)
        <div class="w-full flex bg-gray-800 rounded mb-3 text-white">
            <div class="w-4/12 text-sm font-bold text-center text-5xl p-5 font-bold font-serif">
                <marquee direction="up" onmouseover="this.stop()"  onmouseout="this.start()" id="container-sales-update" class="h-72" Scrollamount=3>
                    @foreach ($budgets as $b)
                        <!-- TEMPLATE NAIK -->
                        <div class="text-white font-mono mb-5">
                            <span class="text-xl">{{ $b->customer_name }}</span><br>
                            <span class="text-sm grid grid-cols-2 gap-4">
                                <span class="text-sm">{{ $b->division }}</span><br>
                                <div>
                                    <i class='fas fa-coins text-sm mr-3 w-3'></i><span class="text-sm">IDR. {{ $b->achievement_1m_actual }}</span><br>
                                    IDR. {{ number_format($b->budget - $b->achievement_1m_raw,0,',','.') }} Left
                                </div>
                                <div class="text-right text-3xl">
                                    <div class="{{ $b->achievement_1m_color }}">
                                        {{ $b->achievement_1m_percentage }}%
                                    </div>
                                </div>
                            </span>
                        </div>
                    @endforeach
                </marquee>
            </div>
            <div class="w-4/12 text-sm text-center mb-1 p-5 font-serif">
                <span><b>Current Month</b></span>
                <br>
                <span class="text-6xl">{{ $totalPercentage }} %</span>
                <br>
                <span>IDR. {{ $totalAchievement }} / {{ $totalBudget }}</span>
                <br><br>
                <span><b>Year to Date</b></span>
                <br>
                <span class="text-6xl">{{ $totalPercentageYTD }} %</span>
                <br>
                <span>IDR. {{ $totalAchievementYTD }} / {{ $totalBudgetYTD }}</span>
            </div>
            <div class="w-4/12 cursor-pointer text-sm text-left justify-center relative p-5 rounded-3xl relative">
                <a target="_blank" href="/sales/export/generate-report/created_date/all/all/{{ Auth::user()->name }}/all/false">
                    <div class="relative">
                        <img src="{{ asset('assets/novena/images/sales-card-background.png') }}" class="rounded-3xl"/>
                        <div class="absolute bottom-0 bg-black w-full rounded-b-3xl p-3 bg-opacity-80">
                            <b class="text-3xl">EDWIN</b>
                            <br>
                            Sales This Month
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endif

    <div class="w-full flex">
        <div class="w-1/2 text-sm font-bold text-center mb-2 text-5xl font-bold font-serif">
            DAILY HEADLINE
        </div>
        <div class="w-1/2 text-sm text-left">
            <b>Latest Transaction Status Time Period : </b><span id="news-update-dayname"></span>
            <br>
            <b>Comparison Time Period : </b><span id="news-update-dayname-before"></span>
        </div>
    </div>

    <div class="news-update w-full mb-5 bg-gray-800 rounded py-3">
        <marquee onmouseover="this.stop()"  onmouseout="this.start()" id="container-news-update" class="" Scrollamount=6>
            <!-- TEMPLATE NAIK -->
            <div class="text-white font-mono text-2xl inline-block mr-20">
                SINAR MAS AGRO AND <br>
                <span class="text-sm grid grid-cols-2 gap-4">
                    <div>
                        <i class='fas fa-shipping-fast text-sm mr-3 w-3'></i><span class="text-sm"></span>231.322.340 ( 28 <i class="text-md fas fa-boxes"></i> )<br>
                        <i class="fas fa-truck-moving text-sm mr-3 w-3"></i> <span class="text-sm">4 Depart</span> <br>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl text-green-500">
                            <i class='fas fa-chevron-circle-up'></i> 0.68%
                        </div>
                    </div>
                </span>
            </div>

            <!-- TEMPLATE TURUN -->
            <div class="text-white font-mono text-2xl inline-block mr-20">
                PT. NIRWANA LESTARI <br>
                <span class="text-sm grid grid-cols-2 gap-4">
                    <div>
                        <i class='fas fa-shipping-fast text-sm mr-3 w-3'></i><span class="text-sm"></span>231.322.340 ( 28 <i class="text-md fas fa-boxes"></i> )<br>
                        <i class="fas fa-truck-moving text-sm mr-3 w-3"></i> <span class="text-sm">4 Depart</span> <br>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl text-red-500">
                            <i class='fas fa-chevron-circle-down'></i> 0.68%
                        </div>
                    </div>
                </span>
            </div>

            <!-- TEMPLATE SAMA -->
            <div class="text-white font-mono text-2xl inline-block mr-20">
                PT. NIRWANA LESTARI <br>
                <span class="text-sm grid grid-cols-2 gap-4">
                    <div>
                        <i class='fas fa-shipping-fast text-sm mr-3 w-3'></i><span class="text-sm"></span>231.322.340 ( 28 <i class="text-md fas fa-boxes"></i> )<br>
                        <i class="fas fa-truck-moving text-sm mr-3 w-3"></i> <span class="text-sm">4 Depart</span> <br>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl text-yellow-500">
                            <i class='fas fa-minus-circle'></i> 0.00%
                        </div>
                    </div>
                </span>
            </div>

            <!-- TEMPLATE TIDAK ADA ORDER -->
            <div class="text-white font-mono text-2xl inline-block mr-20">
                PT. NIRWANA LESTARI <br>
                <span class="text-sm grid grid-cols-2 gap-4">
                    <div>
                        <i class='fas fa-shipping-fast text-sm mr-3 w-3'></i><span class="text-sm"></span>231.322.340 ( 28 <i class="text-md fas fa-boxes"></i> )<br>
                        <i class="fas fa-truck-moving text-sm mr-3 w-3"></i> <span class="text-sm">4 Depart</span> <br>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl text-gray-500">
                            <i class='fas fa-question-circle'></i> -
                        </div>
                    </div>
                </span>
            </div>
        </marquee>
    </div>

    
    <!--Legend-->
    <div class="w-full px-2 pb-3 mt-3 grid grid-cols-3 gap-4">
        <div>
            <i class="fas fa-clipboard-check w-3 mx-2"></i>  POD
        </div>
        <div>
            <i class="fas fa-coins w-3 mx-2"></i> Websettle
            <i class="fas fa-shipping-fast w-3 mx-2"></i> Last Departure
            <i class="fas fa-dolly w-3 mx-2"></i> Last Load
        </div>
        <div>
            <i class="fas fa-balance-scale-right w-3 mx-2"></i> Net Profit
        </div>
    </div>

    <div class="w-full grid grid-cols-3 gap-4">
        <!-- POD performance -->
        <div class="relative w-full mb-6 shadow-lg rounded bg-white">
            <div class="w-full p-5">
                <a href="/sales/truck/performance-customer/all/surabaya/all/created_date/pod" target="_blank"><h1 class="text-left text-xl hover:text-blue-500 cursor-pointer">POD Progress <i class="fas fa-angle-right ml-3"></i></h1></a>
            </div>
            <div class="w-full flex px-5 mb-5">
                <div id="pod-1" class="landing-headline-active headline-pod">
                    H-1
                </div>
                <div id="pod-7" class="landing-headline-inactive headline-pod">
                    1W
                </div>
                <div id="pod-30" class="landing-headline-inactive headline-pod">
                    1M
                </div>
                <div id="pod-90" class="landing-headline-inactive headline-pod">
                    3M
                </div>
                <div id="pod-mtd" class="landing-headline-inactive headline-pod">
                    MTD
                </div>
                <div id="pod-ytd" class="landing-headline-inactive headline-pod">
                    YTD
                </div>
            </div>
            <div id="container-headline-pod" class="overflow-y-auto h-72">
                <!-- Itemlist Card -->
                <div class="w-full flex p-2">
                    <div class="w-2/12 h-auto p-2">
                        <img class="h-full w-full object-contain" src="{{ asset('assets/icons/customers/3000005193.png') }}" alt="">
                    </div>
                    <div class="w-4/12 truncate ...">
                        <p class="p-2">
                            <span class="font-bold text-lg">3000005193</span>
                            <br>
                            <span class="w-full text-gray-500 text-xs truncate">SINAR MAS AGRO RESOURCES AND INAR MAS AGRO RESOURCES AND INAR MAS AGRO RESOURCES AND</span>
                        </p>
                    </div>
                    <div class="w-6/12 px-4 flex inline-block align-middle justify-center">
                        <p class="py-2 text-center">
                            <span class="text-green-500 font-bold text-2xl">73%</span>
                            <br>
                            <i class="fas fa-clipboard-check w-3 mr-2"></i>42/78
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Websettle performance -->
        <div class="relative w-full mb-6 shadow-lg rounded bg-white">
            <div class="w-full p-5">
                <a target="_blank" href="/sales/truck/performance-customer/all/surabaya/all/created_date/websettle"><h1 class="text-left text-xl hover:text-blue-500 cursor-pointer">Websettle Progress <i class="fas fa-angle-right ml-3"></i></h1></a>
            </div>
            <div class="w-full flex px-5 mb-5">
                <div id="websettle-1" class="landing-headline-active headline-websettle">
                    H-1
                </div>
                <div id="websettle-7" class="landing-headline-inactive headline-websettle">
                    1W
                </div>
                <div id="websettle-30" class="landing-headline-inactive headline-websettle">
                    1M
                </div>
                <div id="websettle-90" class="landing-headline-inactive headline-websettle">
                    3M
                </div>
                <div id="websettle-mtd" class="landing-headline-inactive headline-websettle">
                    MTD
                </div>
                <div id="websettle-ytd" class="landing-headline-inactive headline-websettle">
                    YTD
                </div>
            </div>
            <div id="container-headline-websettle" class="overflow-y-auto h-72">
                <!-- Itemlist Card -->
                <div class="w-full flex p-2">
                    <div class="w-2/12 h-auto p-2">
                        <img class="h-full w-full object-contain" src="{{ asset('assets/icons/customers/3000005193.png') }}" alt="">
                    </div>
                    <div class="w-4/12 truncate ...">
                        <p class="p-2">
                            <span class="font-bold text-lg">3000005193</span>
                            <br>
                            <span class="w-full text-gray-500 text-xs truncate">SINAR MAS AGRO RESOURCES AND INAR MAS AGRO RESOURCES AND INAR MAS AGRO RESOURCES AND</span>
                        </p>
                    </div>
                    <div class="w-6/12 px-4 flex inline-block align-middle justify-center">
                        <p class="py-2 text-center">
                            <span class="text-green-500 font-bold text-2xl">73%</span>
                            <br>
                            <i class="fas fa-coins w-3 mr-2"></i>42/78
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gainer -->
        <div class="relative w-full mb-6 shadow-lg rounded bg-white">
            <div class="w-full p-5">
                <a target="_blank" href="/sales/truck/performance-customer/all/surabaya/all/created_date/all"><h1 class="text-left text-xl hover:text-blue-500 cursor-pointer">Top Profit <i class="fas fa-angle-right ml-3"></i></h1></a>
            </div>
            <div class="w-full flex px-5 mb-5">
                <div id="profit-1" class="landing-headline-active headline-profit">
                    H-1
                </div>
                <div id="profit-7" class="landing-headline-inactive headline-profit">
                    1W
                </div>
                <div id="profit-30" class="landing-headline-inactive headline-profit">
                    1M
                </div>
                <div id="profit-90" class="landing-headline-inactive headline-profit">
                    3M
                </div>
                <div id="profit-mtd" class="landing-headline-inactive headline-profit">
                    MTD
                </div>
                <div id="profit-ytd" class="landing-headline-inactive headline-profit">
                    YTD
                </div>
            </div>
            
            <div id="container-headline-gainer" class="overflow-y-auto h-72">
                <!-- Itemlist Card -->
                <div class="w-full flex p-2">
                    <div class="w-2/12 h-auto p-2">
                        <img class="h-full w-full object-contain" src="{{ asset('assets/icons/customers/3000005193.png') }}" alt="">
                    </div>
                    <div class="w-4/12 truncate ...">
                        <p class="p-2">
                            <span class="font-bold text-lg">3000005193</span>
                            <br>
                            <span class="w-full text-gray-500 text-xs truncate">SINAR MAS AGRO RESOURCES AND INAR MAS AGRO RESOURCES AND INAR MAS AGRO RESOURCES AND</span>
                        </p>
                    </div>
                    <div class="w-6/12 px-4 inline-block align-middle">
                        <p class="py-2 text-green-500">
                            <span class="text-sm">+XXX.XXX.XXX</span>
                            <br>
                            <span class="">+35%</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full">
        <!-- Daily Utility -->
        <div class="relative w-full mb-6 shadow-lg rounded bg-white">
            <div class="w-full p-5">
                <h1 class="text-left text-xl hover:text-blue-500 cursor-pointer">Truck Availability <i class="fas fa-angle-right ml-3"></i></h1>
            </div>
            <div id="container-headline-utility" class="overflow-y-auto h-80">
                <!-- Itemlist Card -->
                <div class="w-full flex p-2">
                    <div class="w-3/12 truncate ...">
                        <p class="p-2">
                            <span class="font-bold text-lg">L323WASD</span>
                            <br>
                            <span class="w-full text-gray-500 text-xs truncate">MAS BAYA</span>
                        </p>
                    </div>
                    <div class="w-4/12 px-4 inline-block align-middle text-center">
                        <p class="p-2">
                            <i class="fas fa-shipping-fast w-5 mr-2"></i>2022/05/25
                            <br>
                            ( 7d ago )
                        </p>
                    </div>
                    <div class="w-4/12 px-4 inline-block align-middle text-center">
                        <p class="p-2">
                            <span class="font-bold text-blue-500 text-xl">ONGOING</span>
                        </p>
                    </div>
                    <div class="w-1/12 flex justify-center p-4">
                        <a class="flex align-middle justify-center text-center bg-blue-300 rounded w-full hover:bg-blue-400" href="#" target="_blank"><button id="0"><i class="fas fa-dolly"></i></button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="relative w-full mb-6 shadow-lg rounded bg-white">
        <div class="w-full pt-4">
            <h1 class="font-bold text-2xl text-center">Surabaya in 2022</h1>
        </div>
        <div class="w-full">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <canvas id="chartRevenueYearly" width="100%" height="30%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full">
        <div class="w-12/12">
            <div class="mb-6 px-4 py-3 grid grid-cols-4 gap-2">
                <div class="w-full rounded p-4 bg-red-700 text-white">
                    <h1 class="text-center text-2xl">TRANSPORT</h1>
                    <hr class="my-2">
                    <h1 class="text-center font-bold mb-4 text-lg" id="transport-yearly-revenue">IDR. XXX.XXX</h1>
                    <p>
                        <i class='fas fa-shipping-fast'></i> IDR. <span id="transport-yearly-ongoing">XX.XXX</span><br>
                        <i class='fas fa-clipboard-check'></i> IDR. <span id="transport-yearly-pod">XX.XXX</span><br>
                        <i class='fas fa-donate'></i> IDR. <span id="transport-yearly-websettle">XX.XXX</span><br>
                    </p>
                </div>
                <div class="w-full rounded p-4 bg-green-700 text-white">
                    <h1 class="text-center text-2xl">EXIM</h1>
                    <hr class="my-2">
                    <h1 class="text-center font-bold mb-4 text-lg" id="exim-yearly-revenue">IDR. XXX.XXX M</h1>
                    <p>
                        <i class='fas fa-shipping-fast'></i> IDR. <span id="exim-yearly-ongoing">XX.XXX</span><br>
                        <i class='fas fa-clipboard-check'></i> IDR. <span id="exim-yearly-pod">XX.XXX</span><br>
                        <i class='fas fa-donate'></i> IDR. <span id="exim-yearly-websettle">XX.XXX</span><br>
                    </p>
                </div>
                <div class="w-full rounded p-4 bg-sky-700 text-white">
                    <h1 class="text-center text-2xl">BULK</h1>
                    <hr class="my-2">
                    <h1 class="text-center font-bold mb-4 text-lg" id="bulk-yearly-revenue">IDR. XXX.XXX</h1>
                    <p>
                        <i class='fas fa-shipping-fast'></i> IDR. <span id="bulk-yearly-ongoing">XX.XXX</span><br>
                        <i class='fas fa-clipboard-check'></i> IDR. <span id="bulk-yearly-pod">XX.XXX</span><br>
                        <i class='fas fa-donate'></i> IDR. <span id="bulk-yearly-websettle">XX.XXX</span><br>
                    </p>
                </div>
                <div class="w-full rounded p-4 bg-gray-700 text-white">
                    <h1 class="text-center text-2xl">WAREHOUSE</h1>
                    <hr class="my-2">
                    <h1 class="text-center font-bold mb-4 text-lg" id="warehouse-yearly-revenue">IDR. XXX.XXX</h1>
                    <p>
                        <i class='fas fa-shipping-fast'></i> IDR. <span id="warehouse-yearly-ongoing">XX.XXX</span><br>
                        <i class='fas fa-clipboard-check'></i> IDR. <span id="warehouse-yearly-pod">XX.XXX</span><br>
                        <i class='fas fa-donate'></i> IDR. <span id="warehouse-yearly-websettle">XX.XXX</span><br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="relative w-full mb-6 shadow-lg rounded bg-white">
        <div class="w-full p-5">
            <h1 class="text-center font-bold text-2xl">2022 Division Performance</h1>
        </div>
        <div class="w-full">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <canvas id="chartRevenueYearlyTransport" width="100%" height="20%"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full grid grid-cols-2 gap-4">
            <div class="w-full">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <canvas id="chartRevenueYearlyExim" width="100%" height="40%"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <canvas id="chartRevenueYearlyBulk" width="100%" height="40%"></canvas>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="w-full">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <canvas id="chartRevenueYearlyWarehouse" width="100%" height="20%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex">
        <div class="w-full flex grid grid-cols-2 gap-4">
            <div class="grid grid-cols-2 gap-10">
                <a target="_blank" href="/sales/truck/performance-customer/all/transport/all/created_date/all">
                    <div class="inline-block min-w-0 break-words w-full cursor-pointer mb-6 shadow-lg rounded bg-white transition ease-in-out delay-150 hover:bg-red-100 duration-300">
                        <div class="rounded-t mb-0 px-4 py-3 border-0">
                            <div class="flex flex-wrap items-center mb-8">
                                <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-transport-monthly">
                                    <canvas id="chartTransportMonthly" width="100%" height="30%"></canvas>
                                </div>
                            </div>
                            <h1 class="font-bold text-3xl text-center">TRANSPORT</h1>
                            <center>This Month</center>
                        </div>
                    </div>
                </a>
                <a target="_blank" href="/sales/truck/performance-customer/all/exim/all/created_date/all">
                    <div class="inline-block min-w-0 break-words w-full cursor-pointer mb-6 shadow-lg rounded bg-white transition ease-in-out delay-150 hover:bg-green-100 duration-300">
                        <div class="rounded-t mb-0 px-4 py-3 border-0">
                            <div class="flex flex-wrap items-center mb-8">
                                <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-exim-monthly">
                                    <canvas id="chartEximMonthly" width="100%" height="30%"></canvas>
                                </div>
                            </div>
                            <h1 class="font-bold text-3xl text-center">EXIM</h1>
                            <center>This Month</center> 
                        </div>
                    </div>
                </a>
                <a target="_blank" href="/sales/truck/performance-customer/all/bulk/all/created_date/all">
                    <div class="inline-block min-w-0 break-words w-full cursor-pointer mb-6 shadow-lg rounded bg-white transition ease-in-out delay-150 hover:bg-blue-100 duration-300">
                        <div class="rounded-t mb-0 px-4 py-3 border-0">
                            <div class="flex flex-wrap items-center mb-8">
                                <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-bulk-monthly">
                                    <canvas id="chartBulkMonthly" width="100%" height="30%"></canvas>
                                </div>
                            </div>
                            <h1 class="font-bold text-3xl text-center">BULK</h1>
                            <center>This Month</center>
                        </div>
                    </div>
                </a>
                <a target="_blank" href="/sales/truck/performance-customer/all/warehouse/all/created_date/all">
                    <div class="inline-block min-w-0 break-words w-full cursor-pointer mb-6 shadow-lg rounded bg-white transition ease-in-out delay-150 hover:bg-gray-200 duration-300">
                        <div class="rounded-t mb-0 px-4 py-3 border-0">
                            <div class="flex flex-wrap items-center mb-8">
                                <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-warehouse-monthly">
                                    <canvas id="chartWarehouseMonthly" width="100%" height="30%"></canvas>
                                </div>
                            </div>
                            <h1 class="font-bold text-3xl text-center">WAREHOUSE</h1>
                            <center>This Month</center>
                        </div>
                    </div>
                </a>
            </div>

            <div class="inline-block min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center mb-4">
                        <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-transport-daily">
                            <canvas id="chartTransportDaily" width="100%" height="35%"></canvas>
                        </div>
                        <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-exim-daily">
                            <canvas id="chartEximDaily" width="100%" height="30%"></canvas>
                        </div>
                        <div class="flex-auto p-4 canvas-landing-dynamic" id="canvas-bulk-daily">
                            <canvas id="chartBulkDaily" width="100%" height="30%"></canvas>
                        </div>
                    </div>
                    <div class="w-full p-4">
                        <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-sky-500">
                            <span>Completed Loads (CM)</span>
                            <span class="text-right"><span id="landing-completed-loads"></span> Load ID</span>
                        </div>
                        <div class="w-full mb-8 inline-grid grid-cols-2 text-lg font-bold text-blue-500">
                            <span>Accepted Loads (Incomplete)</span>
                            <span class="text-right"><span id="landing-incompleted-loads"></span> Load ID</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
