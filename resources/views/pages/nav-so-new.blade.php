@extends('layouts.admin-layout')

@section('title')
Linc | Register Surat Jalan
@endsection

@section('header')
@include('components.header_no_login')
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
                    <div class="w-full lg:w-8/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name"> No. SJ </label>
                            <input type="text"
                                name="id_so"
                                class="input-id-so border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
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
                                htmlFor="grid-password"> Tanggal Muat </label>
                            <input type="date"
                                name="tgl_muat"
                                class="input-muat border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Penerima </label>
                            <input type="text"
                                name="penerima"
                                class="input-penerima border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Biaya Bongkar </label>
                            <input type="number"
                                name="bongkar"
                                class="input-bongkar border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="0" min=0 readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-8/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Kendaraan </label>
                            <input type="text"
                                name="nopol"
                                class="input-nopol autocomplete-trucks border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <br>
                            <button class="check-truck btn_blue" value="check">Cek Kendaraan</button>
                        </div>
                    </div>

                    <input type="hidden" class="ctr-item" name="ctr_item" value=0>
                    <input type="hidden" class="kategori-truck" name="kategori_truck" value="0">

                    <div class="w-full lg:w-12/12 px-4 py-8">
                        <div class="block w-full  overflow-x-auto">
                            <!-- Items table -->
                            <table id="yajra-datatable-so-items-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-so-items-list">
                                <thead>
                                <tr>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Material Code
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Description
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Qty.
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Gross Weight
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Subtotal Weight
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="so-items-list-body">
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="w-full lg:w-4/12 px-4" >
                        <div class="relative w-full mb-3">
                            <button type="button"
                                class="open-item-modal bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-right"
                                disabled> + </button>
                        </div>
                    </div>
                    <div class="w-full lg:w-4/12 px-4" >
                        <div class="relative w-full mb-3">
                            <h1 class="teks-total-weight">Cargo : Cek Kendaraan...</h1>
                            <input class="input-total-weight" type="hidden" name="total_weight" value="0">
                            <input type="hidden" name="total_qty" class="input-total-qty" value="0">
                        </div>
                    </div>
                    <div class="w-full lg:w-4/12 px-4" >
                        <div class="relative w-full mb-3">
                            <h1 class="teks-utility">Utilitas : Cek Kendaraan...</h1>
                            <input class="input-total-utility" type="hidden" name="total_utility" value="100">
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
@endsection
@include('modals.sj-items-modal');
