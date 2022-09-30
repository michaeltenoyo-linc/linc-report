@extends('sales.layouts.admin-layout')

@section('title')
Linc | Trucking Performance
@endsection

@section('header')
@include('sales.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="text" class="hidden" value="unitPerformance" id="page-content">
    <div class="relative flex flex-col min-w-0 overflow-x-auto break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="block w-full p-8 overflow-x-auto">
            <div class="w-full text-center">
                <span class="text-xl font-bold">Trucking Performance Generator</span>
            </div>
            <div class="w-full mb-8 mt-8">
                <form id="form-trucking-performance" autocomplete="off">
                    <div class="relative grid grid-cols-4 gap-4 mb-3">
                        <div class="mb-4">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="date-filter-between"> From </label>
                            <input 
                                type="date" 
                                class="date-filter-between border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                id="from"
                                >
                        </div>
                        <div class="mb-4">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="date-filter-between"> To </label>
                            <input 
                                type="date" 
                                class="date-filter-between border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                id="to"
                                >
                        </div>
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="constraint">Date Constraint</label>
                            <select required name="constraint" class="input-constraint border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="created_date">Create Date</option>
                                <option value="closed_date">Closed POD</option>
                                <option value="websettle_date">Websettle</option>
                            </select>
                        </div>
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="status">Status</label>
                            <select required name="status" class="input-status border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="pod">Complete POD</option>
                                <option value="websettle">Websettle</option>
                            </select>
                        </div>
                    </div>

                    <div class="relative grid grid-cols-3 gap-4 mb-3">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Ownership</label>
                            <select required name="ownership" class="input-ownership border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                                <option value="OWN">OWNED Surabaya</option>
                                <option value="OPL">OPL Surabaya</option>
                                <option value="GRAHA">GRAHA Surabaya</option>
                                <option value="NOT_SBY_OWNED">Outside Surabaya Owned</option>
                                <option value="NOT_SBY_VENDOR">Outside Surabaya Vendor</option>
                                
                            </select>
                        </div>

                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Division</label>
                            <select required name="division" class="input-division border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <!-- <option value="all">==Semua==</option> -->
                                <option value="surabaya">Surabaya All</option>
                                <option value="transport">Surabaya Transport</option>
                                <option value="exim">Surabaya ExIm</option>
                                <option value="bulk">Surabaya Bulk</option>
                            </select>
                        </div>
                        
                        <!--
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Load Group</label>
                            <select required name="group" class="input-group border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                                <option value="surabaya">Surabaya</option>
                            </select>
                        </div>
                        -->

                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="tree">Report Tree</label>
                            <select required name="tree" class="input-tree border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="nopol_to_customer">By Vehicle</option>
                                <option value="customer_to_nopol">By Customer</option>
                                <option value="routes_performance">Routes Performance</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="w-full lg:w-12/12" >
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Preview Report Truck Performance -->
                            <div class="preview-truck">
                                <img src="{{ asset('assets/contoh-report/performance-report/truck-preview1.PNG') }}" alt="">
                            </div>
                            <div class="preview-truck">
                                <img src="{{ asset('assets/contoh-report/performance-report/truck-preview2.PNG') }}" alt="">
                            </div>
                            <div class="preview-truck">
                                <img src="{{ asset('assets/contoh-report/performance-report/truck-preview3.PNG') }}" alt="">
                            </div>

                            <!-- Preview Report Customer Performance -->
                            <div class="preview-customer hidden">
                                <img src="{{ asset('assets/contoh-report/performance-report/customer-preview1.PNG') }}" alt="">
                            </div>
                            <div class="preview-customer hidden">
                                <img src="{{ asset('assets/contoh-report/performance-report/customer-preview2.PNG') }}" alt="">
                            </div>
                            <div class="preview-customer hidden">
                                <img src="{{ asset('assets/contoh-report/performance-report/customer-preview3.PNG') }}" alt="">
                            </div>

                            <div>
                                <div class="flex flex-row-reverse w-full mb-3">
                                    <input type="submit"
                                        class="export-pdf-generate cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 ml-5 rounded text-right"
                                        value="Generate"/>

                                    <input type="submit"
                                        class="export-pdf-download cursor-pointer bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-right"
                                        value="Export"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection