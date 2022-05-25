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
            <div class="w-full mb-8">
                <form id="form-trucking-performance" autocomplete="off">
                    <div class="relative mb-4">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="date-filter"> Periode </label>
                        <input 
                            type="month" 
                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            id="date-filter"
                            >
                    </div>

                    <div class="relative grid grid-cols-4 gap-4 mb-3">
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
                                htmlFor="name">Nopol</label>
                            <select required name="sales" class="input-nopol border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                            </select>
                        </div>

                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="tree">Report Tree</label>
                            <select required name="tree" class="input-tree border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="nopol_to_customer">Vehicle Performance</option>
                                <option value="customer_to_nopol">Customer Performance</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="w-full lg:w-12/12" >
                        <div class="flex flex-row-reverse w-full mb-3">
                            <input type="submit"
                                class="export-pdf-generate bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-right"
                                value="Generate"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
