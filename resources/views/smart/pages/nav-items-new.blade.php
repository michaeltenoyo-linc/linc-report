@extends('smart.layouts.admin-layout')

@section('title')
Linc | New Item
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
                        Detail Item
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <form id="form-items-new" autocomplete="off">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> Product Information </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-8/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name"> Material Code </label>
                            <input type="text"
                                name="material_code"
                                class="input-id-item border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <br>
                            <button class="check-item btn_blue" value="check">Cek Kode</button>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Deskripsi </label>
                            <input type="text"
                                name="description"
                                class="input-item-deskripsi border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Gross Weight (Kg. ) </label>
                            <input type="number"
                                name="gross_weight"
                                class="input-item-grossw border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                min=0
                                inputmode="decimal"
                                value="0.01"
                                step=".01" readonly/>
                        </div>
                    </div>
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Nett Weight (Kg. )</label>
                            <input type="number"
                                min="0"
                                name="nett_weight"
                                class="input-item-nettw border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                value="0.01"
                                inputmode="decimal"
                                step=".01"
                                readonly/>
                        </div>
                    </div>
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Category </label>
                            <input type="text"
                                min="0"
                                name="category"
                                class="input-item-category border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                value="Branded"
                                readonly
                            />
                        </div>
                    </div>
                    <div class="w-full lg:w-12/12 px-4" >
                        <div class="flex flex-row-reverse w-full mb-3">
                            <input type="submit"
                                class="input-item-submit bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                value="Simpan" disabled/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
