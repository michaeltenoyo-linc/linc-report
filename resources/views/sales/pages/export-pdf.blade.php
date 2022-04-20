@extends('sales.layouts.admin-layout')

@section('title')
Linc | Export PDF
@endsection

@section('header')
@include('sales.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="text" class="hidden" value="exportPDF" id="page-content">
    <div class="relative flex flex-col min-w-0 overflow-x-auto break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="block w-full p-8 overflow-x-auto">
            <div class="w-full mb-8">
                <form id="form-export-sales" autocomplete="off">
                    <div class="relative mb-4">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="date-filter"> Periode </label>
                        <input 
                            type="month" 
                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            id="date-filter"
                            >
                    </div>

                    <div class="relative grid grid-cols-3 gap-4 mb-3">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Division</label>
                            <select required name="division" class="input-division border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                                <option value="transport">Transport</option>
                                <option value="exim">ExIm</option>
                                <option value="bulk">Bulk</option>
                            </select>
                        </div>

                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Sales</label>
                            <select required name="sales" class="input-sales border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
                                <option value="adit">Adit</option>
                                <option value="edwin">Edwin</option>
                                <option value="willem">Willem</option>
                            </select>
                        </div>

                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Customer</label>
                            <select required name="customer" class="input-customer border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                                <option value="all">==Semua==</option>
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
