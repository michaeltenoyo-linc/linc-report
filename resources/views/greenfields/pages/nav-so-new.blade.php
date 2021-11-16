@extends('greenfields.layouts.admin-layout')

@section('title')
Linc | Register Surat Jalan
@endsection

@section('header')
@include('greenfields.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Detail SO
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <form id="form-so-new" autocomplete="off">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> SO Information </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-3/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name"> No. Order </label>
                            <input type="text"
                                name="order1"
                                class="input-order1 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/12 pt-8">
                        <div class="relative text-center w-full mb-3">
                            /
                        </div>
                    </div>
                    <div class="w-full lg:w-3/12 px-4 pt-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"></label>
                            <input type="text"
                                name="order2"
                                class="input-order2 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <br>
                            <button class="check-sj btn_blue" value="check">Cek Surat Jalan</button>
                        </div>
                    </div>



                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Load ID </label>
                            <input type="text"
                                name="load_id"
                                class="input-loadid border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Order Date </label>
                            <input type="date"
                                name="order_date"
                                class="input-date border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Destination </label>
                            <input type="text"
                                name="destination"
                                class="input-destination border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Quantity </label>
                            <input type="number"
                                name="qty"
                                class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="0.00" step=".01" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Note </label>
                            <input type="text"
                                name="note"
                                class="input-note border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="tidak ada" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Biaya Multidrop </label>
                            <input type="number"
                                name="multidrop"
                                class="input-multidrop border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="0" min="0" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Biaya Unloading </label>
                            <input type="number"
                                name="unloading"
                                class="input-unloading border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="0" min=0 readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Biaya Other </label>
                            <input type="number"
                                name="other"
                                class="input-other border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="0" min=0 readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4" >
                        <div class="flex flex-row-reverse w-full mb-3">
                            <input type="submit"
                                class="btn-simpan bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                value="Simpan" disabled/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dot-elastic"></div>
@endsection
