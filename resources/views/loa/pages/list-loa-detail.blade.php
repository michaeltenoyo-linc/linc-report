@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')

<style>
    .content{
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' version='1.1' height='100px' width='100px'><text transform='translate(20, 100) rotate(-45)' fill='rgb(245,45,45, 0.2)' font-size='15'>Linc Group</text></svg>");
    }
</style>
@endsection

@section('content')
<input type="hidden" name="page-content" id="page-content" value="list-loa-detail">
<input type="hidden" name="" id="loa-type" value="{{ $type }}">
<input type="hidden" name="user-priviledge" id="user-priviledge" value="{{ $isAdmin }}">
<div class="w-full mb-12 px-4">
    <div class="relative content p-10 flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="w-full bg-gradient-to-r from-red-700 to-red-300 p-2 text-white font-bold italic text-sm">
            CONFIDENTAL
        </div>
        <div class="w-full mb-10 flex h-48 items-center">
            <div class="w-2/12 text-center">
                @if (file_exists(public_path().'/assets/icons/customers/'.$customer->reference.'.png'))
                    <img src="{{ asset('/assets/icons/customers/'.$customer->reference.'.png') }}">
                @else
                    <img src="{{ asset('/assets/icons/customers/default.png') }}">
                @endif
            </div>
            <div class="w-10/12 text-center">
                <div class="text-lg" id="customer_reference">{{ $customer->reference }}</div>
                <div class="font-bold text-3xl" ><u id="customer_name">{{ $customer->name }}</u></div>
                <div class="uppercase" id="loa_type">{{ $customer->type_full }}</div>
                <input type="hidden" name="type" id="loa_type_short" value="{{ $customer->type }}">
            </div>
        </div>
        
        <!-- LOA Sub-Group Tab -->
        <input type="hidden" name="" id="selected-timeline" value="">
        <div class="w-full ml-2">
            <ul id="tab-container" class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <!-- Tab List Items -->
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-active">Profile</a>
                </li>
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-inactive">Dashboard</a>
                </li>
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-inactive">Settings</a>
                </li>
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-inactive">Contacts</a>
                </li>
            </ul>
        </div>

        <!--Tab Content-->
        <div class="w-full flex">
            <div class="w-8/12 p-5 border-2 border-gray-500 rounded-lg mr-3">
                <div class="w-full mx-auto flex items-center justify-center mb-4">
                    <input id="loa-archive-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="loa-archive-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Show Archive</label>
                </div>
                <!--Archive Section-->
                <div class="bg-gray-200 mx-auto w-full">
                    <div class="relative wrap overflow-y-auto p-5 h-96">
                        <div class="border-2-2 absolute border-opacity-20 border-gray-700 h-full border" style="left: 30%"></div>
                        
                        <div id="timeline-list">
                            <!-- timeline list items -->
                            <div class="mb-12 flex justify-between items-center w-full">
                                <div class="w-1">
    
                                </div>
                                <div class="z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">
                                    <h1 class="mx-auto font-semibold text-lg text-right text-white">1</h1>
                                </div>
                                <div id="timeline-context" class="timeline cursor-pointer order-1 bg-gray-400 hover:bg-gray-300 rounded-lg shadow-xl w-10/12 px-6 py-4">
                                    <h3 class="mb-3 font-bold text-gray-800 text-xl">Context Title</h3>
                                    <p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">
                                        <b class="text-gray-800">Effective :</b> DD/MM/YYYY <b class="bg-red-600 text-gray-800">| Expired :</b> DD/MM/YYYY
                                    </p>
                                </div>
                            </div>

                            <div class="mb-8 flex justify-between flex-row-reverse items-center w-full left-timeline">
                                <div class="order-1 w-5/12"></div>
                                <div class="z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">
                                  <h1 class="mx-auto text-white font-semibold text-lg">2</h1>
                                </div>
                                <div class="order-1 bg-red-400 rounded-lg shadow-xl w-5/12 px-6 py-4">
                                  <h3 class="mb-3 font-bold text-white text-xl">Lorem Ipsum</h3>
                                  <p class="text-sm font-medium leading-snug tracking-wide text-white text-opacity-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Archive Section-->
            </div>
            <div class="w-4/12 p-5 border-2 border-gray-500 rounded-lg">
                <input type="hidden" name="" id="selected-loa-id" value="">
                <div class="w-full text-center font-bold text-xl mb-5" id="file-group-name">
                    << Choose a Context >>
                </div>
                <div class="w-full flex justify-center overflow-y-auto h-64">
                    <ul id="file-container" class="bg-white rounded-lg w-96 text-gray-900">
                        <!--Files Itemlist-->
                        <li class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">
                            <div class="w-full">File PDF kontrak full<span class="text-xs bg-red-700 text-white rounded p-1 ml-3">.PDF</span></div>
                        </li>
                        <li class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">
                            <div class="w-full">Detail Harga Rute<span class="text-xs bg-lime-700 text-white rounded p-1 ml-3">.XLSX</span></div>
                        </li>
                        <li class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">
                            <div class="w-full">Bukti Foto Struk DP<span class="text-xs bg-yellow-700 text-white rounded p-1 ml-3">.JPG</span></div>
                        </li>
                    </ul>
                </div>

                @if($isAdmin == 'true')
                <div class="w-full">
                    <div class="w-12/12 my-5 flex justify-end">
                        <div></div>
                        <button id="" type="button" class="btn-delete-all-file text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <span class="mr-2">Delete All</span> <i class='fas fa-folder-plus'></i>
                        </button>
                        <button id="" type="button" class="btn-add-file text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span class="mr-2">Add File</span> <i class='fas fa-folder-plus'></i>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <hr>

        <!-- LOA Detail Tree -->
        <div class="w-full my-5 px-4 py-5 border border-4 border-dashed border-blue-300">
            <div class="w-full text-center font-bold text-2xl px-4">
                Detail Harga
            </div>
            <div class="w-full text-center text-red-500 px-4">
                Choose a main LOA to show
            </div>

            @if($type == 'cml')
                <table class="table-loa-rates w-full text-sm text-left text-gray-500 dark:text-gray-400 my-5 hidden">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Description
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Cost
                            </th>
                            <th scope="col" class="py-3 px-6">
                                UoM
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Duration
                            </th>
                            <th scope="col" class="py-3 px-6">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-loa-rates-values">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <input type="hidden" name="id_loa" id="id-loa" class="row-name-0" value="0">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Storage Rate
                            </th>
                            <td class="py-4 px-6">
                                10.000.000
                            </td>
                            <td class="py-4 px-6">
                                /PP
                            </td>
                            <td class="py-4 px-6">
                                /Month
                            </td>
                            <td>
                                <button id="0" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                    <i class="far fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if($isAdmin == 'true')
                    <div class="w-full flex justify-center table-loa-rates hidden">
                        <button id="btn-show-rate-form" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            Add Rate Cost
                        </button>
                    </div>

                    <form id="form-rate-detail" class="hidden">
                        <div id="container-loa-rates" class="w-full justify-center border border-4 border-red-500 border-dashed px-4 py-5 my-5">
                            <div class="w-full text-center font-bold py-5">
                                Add Cost
                            </div>
                            <input type="hidden" id="counter-rates" name="counter-rates" value=0>
                            <div class="loa-other-rate-0">
                                <!--Input Rate-->
                                <div class="inline-block relative w-2/12 mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Cost Name</label>
                                    <input type="text"
                                        name="rate_name[0]"
                                        class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="Other"
                                        required/>
                                </div>
                                <div class="inline-block relative w-3/12 mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Rate</label>
                                    <input type="number"
                                        name="rate[0]"
                                        class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="0"
                                        required/>
                                </div> /
                                <div class="inline-block relative w-2/12 mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">QTY</label>
                                    <input type="text"
                                        name="qty[0]"
                                        class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="PP"
                                        required/>
                                </div> /
                                <div class="inline-block relative w-2/12 mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Duration</label>
                                    <input type="text"
                                        name="duration[0]"
                                        class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="Month"
                                        required/>
                                </div>
                                <div class="inline-block relative ml-2 w-1/12">
                                    <button class="btn-delete-rate text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <!---->
                            </div>
                        </div>
                        <div class="w-full flex justify-center mb-3">
                            <button class="btn-add-rate text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="w-full flex justify-center" >
                            <input type="submit"
                                    class="btn-simpan cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                    value="Simpan"/>
                        </div>
                    </form>
                @endif
            @elseif ($type == 'bp')
                <!-- BP AUTOCOMPLETE -->
                <datalist id="truck-types">
                    @foreach ($vehicle_type as $truck)
                        <option value="{{ $truck->reference }}"></option>
                    @endforeach
                </datalist>
                
                <datalist id="indo-regions">
                    @foreach ($regions as $r)
                        <option value="{{ $r }}"></option>
                    @endforeach
                </datalist>
                <!-- END BP AUTO COMPLETE -->
                
                <!-- TAB SECTION -->
                <div class="flex flex-wrap hidden services-bp-tab mb-5" id="tabs-id">
                    <div class="w-full">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-blue-600" onclick="changeActiveTab(event,'tab-profile', 'tabs-id', 'tab-content')">
                            <i class="fas fa-truck-moving text-base mr-1"></i>  Rental
                        </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" onclick="changeActiveTab(event,'tab-settings', 'tabs-id', 'tab-content')">
                            <i class="fas fa-clipboard-list text-base mr-1"></i>  Excess / Variables
                        </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" onclick="changeActiveTab(event,'tab-options', 'tabs-id', 'tab-content')">
                            <i class="fas fa-route text-base mr-1"></i>  On Call Routes
                        </a>
                        </li>
                    </ul>
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                            <div class="px-4 py-5 flex-auto">
                                <div class="tab-content tab-space">
                                    <div class="block" id="tab-profile">
                                    <!-- Fixed Rental Charges -->
                                    <div class="w-full mb-5 content-rental">
                                        <div class="w-full text-center text-red-500 font-bold">
                                            LOA ini tidak memiliki services fixed rental
                                        </div>
                                        <table id="yajra-datatable-bp-rental" class="items-center w-full bg-transparent border-collapse yajra-datatable-bp-rental">
                                            <thead>
                                              <tr>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Site
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Vehicle Type
                                                    </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Rental Charge
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    UoM
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Category
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Action
                                                </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END SECTION -->
                                    </div>
                                    <div class="hidden" id="tab-settings">
                                    <!-- EXCESS CHARGES -->
                                    <div class="w-full mb-5 content-excess">
                                        <div class="w-full text-center text-red-500 font-bold">
                                            LOA ini tidak memiliki services excess/variables
                                        </div>
                                        <table id="yajra-datatable-bp-excess" class="items-center w-full bg-transparent border-collapse yajra-datatable-bp-excess">
                                            <thead>
                                              <tr>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Charges Name
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Vehicle Type
                                                    </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Rate
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    UoM
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Action
                                                </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END SECTION -->
                                    </div>
                                    <div class="hidden" id="tab-options">
                                    <!-- ON CALL ROUTES CHARGES -->
                                    <div class="w-full mb-5 content-routes">
                                        <div class="w-full text-center text-red-500 font-bold">
                                            LOA ini tidak memiliki services on call routes
                                        </div>
                                        <table id="yajra-datatable-bp-routes" class="items-center w-full bg-transparent border-collapse yajra-datatable-bp-routes">
                                            <thead>
                                              <tr>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Vehicle Type
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Origin
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Destination
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Rate
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Action
                                                </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END SECTION -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END TAB SECTION -->

                @if($isAdmin == 'true')
                    <div class="w-full flex justify-center table-loa-rates services-bp-tab hidden mb-5">
                        <button id="btn-show-rate-form" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                            Add Rate Cost
                        </button>
                    </div>

                    <form id="form-rate-bp" class="hidden">
                        <div class="w-full flex justify-center mb-5">
                            <button type="submit" id="btn-save-bp-rates" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">
                                Save Changes
                            </button>
                        </div>
                        <!-- TAB SECTION -->
                        <div class="flex flex-wrap" id="tabs-id-input">
                            <div class="w-full">
                            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-blue-600" onclick="changeActiveTab(event,'input-rental', 'tabs-id-input', 'tab-content-input')">
                                    <i class="fas fa-truck-moving text-base mr-1"></i>  Rental
                                </a>
                                </li>
                                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" onclick="changeActiveTab(event,'input-excess', 'tabs-id-input', 'tab-content-input')">
                                    <i class="fas fa-clipboard-list text-base mr-1"></i>  Excess / Variables
                                </a>
                                </li>
                                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" onclick="changeActiveTab(event,'input-routes', 'tabs-id-input', 'tab-content-input')">
                                    <i class="fas fa-route text-base mr-1"></i>  On Call Routes
                                </a>
                                </li>
                            </ul>
                            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                                    <div class="px-4 py-5 flex-auto">
                                        <div class="tab-content-input tab-space">
                                            <div class="block" id="input-rental">
                                            <!-- Fixed Rental Charges -->
                                            <div class="w-full">
                                                <div class="w-full text-center text-red-500 font-bold mb-5">
                                                    Jika tidak memiliki service fixed rental, dapat melanjutkan pengisian charges lain.
                                                </div>
                                                <div class="w-full">
                                                    <center>
                                                        <div class="w-full flex justify-center mb-3">
                                                            <div class="inline-block relative ml-2 w-1/12">
                                                                <button class="btn-add-rental text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div id="container-loa-rental" style="max-height: 36rem;" class="overflow-y-scroll">
                                                            <input type="hidden" id="counter-rental" name="counter-rental" value=-1>
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>
                                            <!-- END SECTION -->
                                            </div>
                                            <div class="hidden" id="input-excess">
                                            <!-- EXCESS CHARGES -->
                                            <div class="w-full mb-5">
                                                <div class="w-full text-center text-red-500 font-bold">
                                                    Jika tidak memiliki tambahan excess/variables, dapat melanjutkan pengisian charges lain.
                                                </div>
                                            </div>
                                            <center>
                                                <div class="w-full flex justify-center mb-3">
                                                    <div class="inline-block relative ml-2 w-1/12">
                                                        <button class="btn-add-excess text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="container-loa-excess" style="max-height: 36rem;" class="overflow-y-scroll">
                                                    <input type="hidden" id="counter-excess" name="counter-excess" value=-1>
                                                </div>
                                            </center>
                                            <!-- END SECTION -->
                                            </div>
                                            <div class="hidden" id="input-routes">
                                            <!-- ON CALL ROUTES CHARGES -->
                                            <div class="w-full mb-5">
                                                <div class="w-full text-center text-red-500 font-bold">
                                                    Jika tidak memiliki tambahan on call routes, dapat melanjutkan pengisian charges lain.
                                                </div>
                                            </div>
                                            <center>
                                                <div class="w-full flex justify-center mb-5">
                                                    <div class="inline-block relative ml-2 w-1/12">
                                                        <button class="btn-add-routes text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="container-loa-routes" style="max-height: 36rem;" class="overflow-y-scroll">
                                                    <input type="hidden" id="counter-routes" name="counter-routes" value=-1>
                                                </div>
                                            </center>
                                            <!-- END SECTION -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END TAB SECTION -->
                    </form>
                @endif
            @endif

        </div>

        <!-- LOA File Viewer -->
        <div class="w-full my-5 px-4">
            <div class="w-full text-center font-bold text-2xl px-4">
                File Viewer
            </div>
            <div class="w-full text-center text-red-500 px-4">
                Choose a file to show
            </div>
        </div>

        <!-- FILES CONTAINER -->
        <!-- PDF -->
        <div id="pdf" class="viewer-container flex flex-nowrap py-8 px-4 text-center hidden">
            <div id="pdf-viewer" style="height: 800px;" class="w-full lg:w-12/12 px-4">
                <!--PDF EMBED GOES HERE-->
            </div>
        </div>
        <!-- EXCEL -->
        <div id="excel" class="w-full viewer-container flex flex-nowrap py-8 px-4 text-center justify-center hidden">
            <a id="open-excel" href="" target="_blank"><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Open File in New Tab</button></a>
        </div>
        <!-- IMAGE -->
        <div id="image" class="w-full viewer-container flex flex-nowrap py-8 px-4 text-center hidden justify-center">
            <img id="img-viewer" src="" alt="image not found." class="w-1/2 px-4 rounded-lg image-loa">
        </div>
        <!-- DOCX -->
        <div id="docx" class="viewer-container flex flex-nowrap py-8 px-4 text-center hidden">

        </div>
        <!-- MSG -->
        <div id="msg" class="w-full viewer-container flex flex-nowrap py-8 px-4 text-center justify-center hidden">
            
        </div>
    </div>
</div>
@endsection

@include('loa.modals.loa-add-file')
@include('loa.modals.loa-error-warning')

@if($type == 'bp')
<script>
    function changeActiveTab(event, tabID, tabContentsId, tabContentsClass) {
        let element = event.target;
        while (element.nodeName !== "A") {
            element = element.parentNode;
        }
        ulElement = element.parentNode.parentNode;
        aElements = ulElement.querySelectorAll("li > a");
        tabContents = document.getElementById(tabContentsId).querySelectorAll("."+tabContentsClass+" > div");
        for (let i = 0; i < aElements.length; i++) {
            aElements[i].classList.remove("text-white");
            aElements[i].classList.remove("bg-blue-600");
            aElements[i].classList.add("text-blue-600");
            aElements[i].classList.add("bg-white");
            tabContents[i].classList.add("hidden");
            tabContents[i].classList.remove("block");
        }
        element.classList.remove("text-blue-600");
        element.classList.remove("bg-white");
        element.classList.add("text-white");
        element.classList.add("bg-blue-600");
        document.getElementById(tabID).classList.remove("hidden");
        document.getElementById(tabID).classList.add("block");
    }
</script>
@endif