@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="page-content" id="page-content" value="input-loa-form">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="flex flex-nowrap">
            <div class="w-full p-10">
                <form id="form-loa-new" autocomplete="off">
                    <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> New Letter Of Agreements</h6>
                    <div class="flex flex-wrap">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Nama LOA <span class="text-red-500">*Bukan nama file, penamaan digunakan untuk judul pada archive history LOA customer</span> </label>
                                <input type="text"
                                    name="name"
                                    class="input-name border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value=""
                                    required/>
                            </div>

                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Sub-Folder LOA <span class="text-red-500">*Subgrup digunakan untuk memisahkan arsip kustomer melalui grup</span> </label>
                                <input type="text"
                                    name="group"
                                    class="input-group border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="Utama"
                                    list="list-group" required/>
                                
                                <datalist id="list-group">
                                    @foreach ($group_list as $g)
                                        <option value="{{ $g->group }}">{{ $g->name }} - {{ $g->group }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Customer <span class="text-red-500">*Jika customer belum terdaftar, harap hubungi admin server</span></label>
                                <input type="text"
                                    name="customer"
                                    class="input-customer border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value=""
                                    list="list-customer" required/>

                                <datalist id="list-customer">
                                    @foreach ($customer as $c)
                                        <option value="{{ $c->reference }}">{{ $c->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Type</label>
                                <input type="text"
                                    name="type"
                                    class="input-type border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="{{ $type }}"
                                    required readonly/>
                            </div>

                            <div class="w-full grid grid-cols-2 gap-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Period Effective In</label>
                                    <input type="date"
                                        name="effective"
                                        class="input-effective border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Expired</label>
                                    <input type="date"
                                        name="expired"
                                        class="input-expired border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                            </div>
                            @if ($type  == 'cml')
                                <!-- DETAIL COST EXTRACT CML-->
                                <div class="w-full relative p-5 mb-3 border border-dashed border-2 border-blue-400">
                                    <center>
                                        <div class="w-full font-bold text-2xl mb-3">
                                            Charges
                                        </div>
                                    </center>
                                    <!--Input Rate-->
                                    <input type="hidden" name="rate_name[0]" value="storage">
                                    <div class="inline-block relative w-7/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Storage Rate</label>
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
                                    <!---->
                                    <hr>
                                    <!--Input Rate-->
                                    <input type="hidden" name="rate_name[1]" value="handling in">
                                    <div class="inline-block relative w-7/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Handling In</label>
                                        <input type="number"
                                            name="rate[1]"
                                            class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="0"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">QTY</label>
                                        <input type="text"
                                            name="qty[1]"
                                            class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="PP"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Duration</label>
                                        <input type="text"
                                            name="duration[1]"
                                            class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Month"
                                            required/>
                                    </div>
                                    <!---->
                                    <hr>
                                    <!--Input Rate-->
                                    <input type="hidden" name="rate_name[2]" value="handling out">
                                    <div class="inline-block relative w-7/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Handling Out</label>
                                        <input type="number"
                                            name="rate[2]"
                                            class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="0"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">QTY</label>
                                        <input type="text"
                                            name="qty[2]"
                                            class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="PP"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Duration</label>
                                        <input type="text"
                                            name="duration[2]"
                                            class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Month"
                                            required/>
                                    </div>
                                    <!---->
                                    <hr>
                                    <!--Input Rate-->
                                    <input type="hidden" name="rate_name[3]" value="vas">
                                    <div class="inline-block relative w-7/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">VAS</label>
                                        <input type="number"
                                            name="rate[3]"
                                            class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="0"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">QTY</label>
                                        <input type="text"
                                            name="qty[3]"
                                            class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="PP"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Duration</label>
                                        <input type="text"
                                            name="duration[3]"
                                            class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Month"
                                            required/>
                                    </div>
                                    <!---->
                                    <hr>
                                    <!--Input Rate-->
                                    <input type="hidden" name="rate_name[4]" value="overtime">
                                    <div class="inline-block relative w-7/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Overtime</label>
                                        <input type="number"
                                            name="rate[4]"
                                            class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="0"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">QTY</label>
                                        <input type="text"
                                            name="qty[4]"
                                            class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="PP"
                                            required/>
                                    </div> /
                                    <div class="inline-block relative w-2/12 mb-3">
                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                            htmlFor="name">Duration</label>
                                        <input type="text"
                                            name="duration[4]"
                                            class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Month"
                                            required/>
                                    </div>
                                    <!---->
                                    <hr>
                                    <div id="container-loa-rates">
                                        <div class="w-full text-center font-bold py-5">
                                            Other Cost
                                        </div>
                                        <input type="hidden" id="counter-rates" name="counter-rates" value=5>
                                        <div class="loa-other-rate-5">
                                            <!--Input Rate-->
                                            <div class="inline-block relative w-2/12 mb-3">
                                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                                    htmlFor="name">Services</label>
                                                <input type="text"
                                                    name="rate_name[5]"
                                                    class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                    value="Other"
                                                    required/>
                                            </div>
                                            <div class="inline-block relative w-3/12 mb-3">
                                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                                    htmlFor="name">Rate</label>
                                                <input type="number"
                                                    name="rate[5]"
                                                    class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                    value="0"
                                                    required/>
                                            </div> /
                                            <div class="inline-block relative w-2/12 mb-3">
                                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                                    htmlFor="name">UoM</label>
                                                <input type="text"
                                                    name="qty[5]"
                                                    class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                    value="PP"
                                                    required/>
                                            </div> /
                                            <div class="inline-block relative w-2/12 mb-3">
                                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                                    htmlFor="name">Duration</label>
                                                <input type="text"
                                                    name="duration[5]"
                                                    class="input-duration border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                    value="Month"
                                                    required/>
                                            </div>
                                            <div class="inline-block relative ml-2 w-1/12">
                                                <button class="btn-delete-rate text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                    <div class="w-full flex justify-center">
                                        <div class="inline-block relative ml-2 w-1/12">
                                            <button class="btn-add-rate text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- DETAIL COST EXTRACT END -->
                            @endif
                            

                            <hr class="my-5">
                            
                            <div class="w-full text-center mb-10">  
                                <label class="block text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">FILE UTAMA<br><span class="text-red-500">*Upload 1 file utama, bila lebih dari satu dapat di upload setelah ini.</span></label>
                            </div>
                            <div class="w-full grid grid-cols-3 gap-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Filename</label>
                                    <input type="text"
                                        name="filename"
                                        class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Upload</label>
                                    <input type="file"
                                        name="file"
                                        class="input-file border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Extension</label>
                                    <select
                                        name="extension"
                                        class="input-extension border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        required>
                                        <option value=".pdf">PDF (.pdf)</option>
                                        <option value=".docx">Office Word (.docm, .docx, .dot, .dotx)</option>
                                        <option value=".xlsx">Spreadsheet (.xlxs, .xlsm, .xlsb, .xltx, .xls)</option>
                                        <option value=".jpg">Image (.jpeg, .jpg, .png)</option>
                                        <option value=".msg">Message (.msg)</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-5">
                            
                            @if ($type  == 'cml')
                                <div class="w-full lg:w-12/12 px-4" >
                                    <div class="flex flex-row-reverse w-full mb-3">
                                        <input type="submit"
                                            class="btn-simpan bg-green-500 cursor-pointer hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                            value="Simpan"/>
                                    </div>
                                </div>
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

                                <div class="w-full text-center mb-10">  
                                    <label class="block text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Services<br><span class="text-red-500">*Harap melengkapi step berikut untuk menyimpan data.
                                        <br>
                                        <u>Pengisian detail harga dapat dilakukan secara bertahap atau menyicil.</u>
                                        </span>
                                    </label>
                                </div>

                                <!-- TAB SECTION -->
                                <div class="flex flex-wrap" id="tabs-id">
                                    <div class="w-full">
                                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-white bg-blue-600" onclick="changeActiveTab(event,'tab-profile')">
                                            <i class="fas fa-truck-moving text-base mr-1"></i>  Rental
                                        </a>
                                        </li>
                                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" onclick="changeActiveTab(event,'tab-settings')">
                                            <i class="fas fa-clipboard-list text-base mr-1"></i>  Excess / Variables
                                        </a>
                                        </li>
                                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                                        <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" onclick="changeActiveTab(event,'tab-options')">
                                            <i class="fas fa-route text-base mr-1"></i>  On Call Routes
                                        </a>
                                        </li>
                                    </ul>
                                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                                            <div class="px-4 py-5 flex-auto">
                                                <div class="tab-content tab-space">
                                                    <div class="block" id="tab-profile">
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
                                                    <div class="hidden" id="tab-settings">
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
                                                    <div class="hidden" id="tab-options">
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

                                {{-- <!-- STEPPER SECTION -->
                                <ul class="stepper" data-mdb-stepper="stepper">
                                    <li class="stepper-step stepper-active">
                                    <div class="stepper-head">
                                        <span class="stepper-head-icon"> 1 </span>
                                        <span class="stepper-head-text"> Fixed Rental </span>
                                    </div>
                                    <div class="stepper-content">
                                        <!-- Fixed Rental Charges -->
                                        <div class="w-full">
                                            <div class="w-full text-center text-red-500 font-bold">
                                                Jika tidak memiliki service fixed rental, dapat melanjutkan pengisian charges lain.
                                            </div>
                                            <div class="w-full grid grid-cols-4 gap-4 section-fixed-rental mb-5">

                                            </div>
                                            <div class="w-full">
                                                <center>
                                                    <button id="btn-add-rental" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                                        Add
                                                    </button>
                                                </center>
                                            </div>
                                        </div>
                                        <!-- END SECTION -->
                                    </div>
                                    </li>
                                    <li class="stepper-step">
                                        <div class="stepper-head">
                                        <span class="stepper-head-icon"> 2 </span>
                                        <span class="stepper-head-text"> Excess/Variables on Call</span>
                                        </div>
                                        <div class="stepper-content">
                                        <!-- EXCESS CHARGES -->
                                        <div class="w-full mb-5">
                                            <div class="w-full text-center text-red-500 font-bold">
                                                Jika tidak memiliki tambahan excess/variables, dapat melanjutkan pengisian charges lain.
                                            </div>
                                        </div>
                                        <center>
                                            <div id="container-loa-rates">
                                                <input type="hidden" id="counter-rates" name="counter-rates" value=0>
                                                <div class="loa-other-rate-0">
                                                    <!--Input Rate-->
                                                    <div class="inline-block relative w-2/12 mb-3">
                                                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                                            htmlFor="name">Services</label>
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
                                                            htmlFor="name">UoM</label>
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
                                                        <button class="btn-delete-rate text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <!---->
                                                </div>
                                            </div>
                                            <div class="w-full flex justify-center">
                                                <div class="inline-block relative ml-2 w-1/12">
                                                    <button class="btn-add-rate text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" id="5">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </center>
                                        <!-- END SECTION -->
                                        </div>
                                    </li>
                                    <li class="stepper-step">
                                    <div class="stepper-head">
                                        <span class="stepper-head-icon"> 3 </span>
                                        <span class="stepper-head-text"> On Call Routes </span>
                                    </div>
                                    <div class="stepper-content">
                                        <div class="w-full lg:w-12/12 px-4" >
                                            <div class="flex flex-row-reverse w-full mb-3">
                                                <input type="submit"
                                                    class="btn-simpan cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                                    value="Simpan"/>
                                            </div>
                                        </div>
                                    </div>
                                    </li>
                                </ul>
                                <!-- END STEPPER SECTION --> --}}
                                <div class="w-full lg:w-12/12 px-4" >
                                    <div class="flex flex-row-reverse w-full mb-3">
                                        <input type="submit"
                                            class="btn-simpan bg-green-500 cursor-pointer hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                            value="Simpan"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@include('loa.modals.loa-error-warning')

<script>
    function changeActiveTab(event, tabID) {
        let element = event.target;
        while (element.nodeName !== "A") {
            element = element.parentNode;
        }
        ulElement = element.parentNode.parentNode;
        aElements = ulElement.querySelectorAll("li > a");
        tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");
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
