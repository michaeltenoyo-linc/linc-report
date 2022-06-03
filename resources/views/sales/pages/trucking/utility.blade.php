@extends('sales.layouts.admin-layout')

@section('title')
Linc | Trucking Utility
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
                <span class="text-xl font-bold">Trucking Utility Monitor</span>
            </div>
            <div class="w-full mb-8">
                <form id="form-trucking-utility" autocomplete="off">
                    <div class="relative mb-4">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="date-filter"> Periode </label>
                        <input 
                            type="month" 
                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            id="date-filter"
                            >
                    </div>

                    <div class="relative grid grid-cols-2 gap-4 mb-3">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Ownership</label>
                            <select required name="ownership" class="input-ownership border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                                <option value="OWN">OWNED Surabaya</option>
                                <option value="OPL">OPL Surabaya</option>
                                <option value="GRAHA">GRAHA Surabaya</option>
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
                    </div>
                    
                    <div class="w-full lg:w-12/12" >
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Preview Utility Generator -->
                            <div class="preview-utility">
                                <img src="{{ asset('assets/contoh-report/performance-report/utility-preview1.PNG') }}" alt="Image not found.">
                            </div>
                            <div class="preview-utility">
                                <img src="{{ asset('assets/contoh-report/performance-report/utility-preview2.PNG') }}" alt="Image not found.">
                            </div>
                            <div class="preview-utility">
                                <img src="{{ asset('assets/contoh-report/performance-report/utility-preview3.PNG') }}" alt="Image not found.">
                            </div>

                            <div>
                                <div class="flex flex-row-reverse w-full mb-3">
                                    <input type="submit"
                                        class="export-pdf-generate bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-right"
                                        value="Generate"/>
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