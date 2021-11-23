@extends('smart.layouts.admin-layout')

@section('title')
Linc | Generate Report
@endsection

@section('header')
@include('smart.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Report Generator
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <form id="form-report-generate" method="POST" action="report/generate">
                @csrf
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> Loads Information </h6>
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name"> Jenis Report </label>
                        <select class="input-report-type w-full border bg-white rounded px-3 py-2 outline-none" name="reportType">
                            <option class="py-1" value="smart_1">Smart Customer 1</option>
                            <option class="py-1" value="smart_2">Smart Customer 2</option>
                        </select>
                    </div>
                </div>
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name"> Customer Type </label>
                        <select class="input-customer-type w-full border bg-white rounded px-3 py-2 outline-none" name="customerType">
                            <option class="py-1" value="smart consumer">SMART CONSUMER</option>
                            <option class="py-1" value="smart industrial">SMART INDUSTRIAL</option>
                            <option class="py-1" value="smart mt">SMART MT</option>
                            <option class="py-1" value="smart pallet">SMART PALLET</option>
                            <option class="py-1" value="smart ecommerce">SMART E-COM</option>
                        </select>
                    </div>
                </div>
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name"> Filter Load ID <div style="color: red;">*Pisahkan dengan tanda semicolon (5040123;4000123;3201230)</div></label>
                        <textarea class="input-customer-loadid w-full border bg-white rounded px-3 py-2 outline-none" name="loadId" id="" cols="100" rows="5"></textarea>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <!--Requirement SMART 1-->
                    <div class="requirement-reportSmart1 w-full lg:w-1/2 px-4">
                        <div class="relative w-full mb-3">
                            <h1 class="text-red-600 font-bold">Requirement SMART Report 1</h1>
                            <p class="text-red-600">
                                Pastikan semua field yang diambil dari Blujay sudah memiliki
                                ketentuan yang dibutuhkan dibawah ini :
                            </p>
                            <br>
                            <ul class="list-disc">
                                <li>TMS ID / Load ID</li>
                                <li>Created Date</li>
                                <li>Last Drop Location City</li>
                                <li>Billable Total Rate</li>
                                <li>Load Status</li>
                            </ul>
                        </div>
                    </div>
                    <div class="preview-reportSmart1 w-full lg:w-1/2 px-4">
                        <div class="relative w-full mb-3">
                            <h1 class="font-bold">Report Smart 1 untuk :</h1>
                        </div>
                        <img src="{{asset('assets/contoh-report/ReportSmart1.jpg')}}" alt="">
                    </div>

                    <!--Requirement SMART 2-->
                    <div class="requirement-reportSmart2 hidden w-full lg:w-1/2 px-4">
                        <div class="relative w-full mb-3">
                            <h1 class="text-red-600 font-bold">Requirement SMART Report 2</h1>
                            <p class="text-red-600">
                                Pastikan semua field yang diambil dari Blujay sudah memiliki
                                ketentuan yang dibutuhkan dibawah ini :
                            </p>
                            <br>
                            <ul class="list-disc">
                                <li>TMS ID / Load ID</li>
                                <li>Created Date</li>
                                <li>Customer Name</li>
                                <li>Billable Method</li>
                                <li>Shipping Comment</li>
                                <li>Pick-up Location Reference Number</li>
                                <li>Delivery Location Name</li>
                                <li>Order Number</li>
                                <li>Carrier Name</li>
                                <li>Last Drop Location City</li>
                                <li>Billable Total Rate</li>
                                <li>Load Status</li>
                            </ul>
                        </div>
                    </div>
                    <div class="preview-reportSmart2 hidden w-full lg:w-1/2 px-4">
                        <div class="relative w-full mb-3">
                            <h1 class="font-bold">Report Smart 2 untuk :</h1>
                            <img src="{{asset('assets/contoh-report/ReportSmart2.png')}}" alt="">
                        </div>
                        
                    </div>

                    <div class="w-full px-4 py-8">
                        <div class="relative w-full mb-3">
                            <hr>
                        </div>
                    </div>
                    
                    <div class="w-full lg:w-6/12 px-4" >
                        <div class="relative w-full w-full mb-3">
                            <h1 class="text-red-600">Pastikan sudah ada/konversi file blujay dalam format .CSV</h1>
                            <h1 class="text-red-600 font-bold">Separator : Semicolon ( ; )</h1>
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4" >
                        <div class="flex flex-row-reverse w-full mb-3">
                            <input type="file"
                                name="bluejay"
                                class="input-bluejay bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                value="Load Bluejay .CSV" />
                        </div>
                    </div>

                    <div class="block w-full p-8  overflow-x-auto">
                        <!-- Projects table -->
                        <table id="yajra-datatable-loads-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-loads-list">
                            <thead>
                            <tr>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    TMS ID
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    Customer ID
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    Created Date
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    Last Drop Location
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    Load Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="w-full lg:w-12/12 px-4" >
                        <div class="flex flex-row-reverse w-full mb-3">
                            <input type="submit"
                                class="report-btn-preview bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                value="Preview and Generate" disabled/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
