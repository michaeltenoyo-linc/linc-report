@extends('loa.layouts.admin-layout')

@section('title')
Linc | Input LOA
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Letter of Agreement
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <form id="form-loa-new" autocomplete="off">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> LOA Information </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Nama Customer</label>
                            <input type="text"
                                name="customer_name"
                                class="input-customer border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Divisi </label>
                            <select 
                                name="divisi" 
                                id="input-divisi" 
                                class="input-divisi border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                <option value="exim">Ekspor-Impor</option>
                                <option value="transport">Transport</option>
                                <option value="warehouse">Warehouse</option>
                                <option value="bulk">Bulk</option>
                            </select>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Harga </label>
                            <input type="number"
                                name="price"
                                class="input-price border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                min=0
                                inputmode="decimal"
                                value="0"/>
                        </div>
                    </div>
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Destinasi </label>
                                <input type="text"
                                name="destination"
                                class="input-destination border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                value=""/>
                        </div>
                    </div>

                    <!--Biaya Tambahan EXIM dan Transport-->
                    <div class="transport-exim w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3 border-4 border-dashed border-blue-300 py-8 px-4">
                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Multidrop </label>
                                    <input type="number"
                                    min=0
                                    name="multidrop"
                                    class="input-multidrop border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Bongkar </label>
                                    <input type="number"
                                    min=0
                                    name="bongkar"
                                    class="input-bongkar border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Overnight </label>
                                    <input type="number"
                                    min=0
                                    name="overnight"
                                    class="input-overnight border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Loading </label>
                                    <input type="number"
                                    min=0
                                    name="loading"
                                    class="input-loading border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Lain </label>
                                    <input type="number"
                                    min=0
                                    name="other"
                                    class="input-other border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>
                        </div>
                    </div>

                    <!--Biaya Tambahan Warehouse-->
                    <div class="warehouse hidden w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3 border-4 border-dashed border-blue-300 py-8 px-4">
                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Handling In/Out </label>
                                    <input type="number"
                                    min=0
                                    name="handling"
                                    class="input-handling border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Overtime </label>
                                    <input type="number"
                                    min=0
                                    name="overtime"
                                    class="input-overtime border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Stand By </label>
                                    <input type="number"
                                    min=0
                                    name="standby"
                                    class="input-standby border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Rental Pallete </label>
                                    <input type="number"
                                    min=0
                                    name="rental"
                                    class="input-rental border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Jasa Titip </label>
                                    <input type="number"
                                    min=0
                                    name="titip"
                                    class="input-titip border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Loading/Unloading </label>
                                    <input type="number"
                                    min=0
                                    name="loading"
                                    class="input-loading border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Management </label>
                                    <input type="number"
                                    min=0
                                    name="management"
                                    class="input-management border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Lain </label>
                                    <input type="number"
                                    min=0
                                    name="other"
                                    class="input-other border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>
                        </div>
                    </div>

                    <!--Biaya Tambahan BULK-->
                    <div class="bulk hidden w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3 border-4 border-dashed border-blue-300 py-8 px-4">
                            <div class="w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Ocean Fret </label>
                                    <input type="number"
                                    min=0
                                    name="oceanfret"
                                    class="input-oceanfret border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="w-full lg:w-12/12 px-4" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Lain </label>
                                    <input type="number"
                                    min=0
                                    name="other"
                                    class="input-other border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4 py-6" >
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Upload PDF Letter of Agreement </label>
                            <input type="file"
                            accept="application/pdf"
                            name="file"
                            class="input-file border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                            value="0"/>
                    </div>

                    <div class="w-full lg:w-12/12 px-4" >
                        <div class="flex flex-row-reverse w-full mb-3">
                            <input type="submit"
                                class="input-item-submit bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                value="Simpan"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
