@extends('pkg.layouts.admin-layout')

@section('title')
Linc | Register Ticket
@endsection

@section('header')
@include('pkg.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Detail Ticket
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <div class="relative w-full">
                <!-- CEK POSTO -->
                <div class="w-7/12 px-4 inline-block">
                    <div class="relative w-full">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name"> No. Posto </label>
                        <input type="text"
                            name="check_posto"
                            class="input-cek-posto border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value=""/>
                    </div>
                </div>
            
                <div class="w-3/12 lg:w-3/12 px-4 inline-block">
                    <div class="relative w-full mb-3">
                        <br>
                        <button id="check-posto" class="btn_blue" value="check">Cek POSTO</button>
                    </div>
                </div>

                <!-- FORM POSTO -->
                <form id="form-posto-new" autocomplete="off" class="form-posto-new w-full p-5 m-5 border-2 border-red-400 rounded hidden">
                    <section id="section-sistro" class="">
                        <div class="w-full text-center px-4 font-bold text-3xl">
                            <h1>SISTRO</h1>
                        </div>

                        <div class="info-posto w-full text-center px-4 mb-5 text-red-600 text-sm">
                            *POSTO belum terdaftar pada database lokal, mohon input POSTO baru.
                        </div>


                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Nomor POSTO </label>
                                <input type="text"
                                    name="posto"
                                    class="input-posto border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="" readonly required/>
                            </div>
                        </div>

                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Tujuan </label>
                                <input type="text"
                                    name="tujuan"
                                    class="input-tujuan border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="" readonly required/>
                            </div>
                        </div>

                        <div class="w-5/12 lg:w-5/12 px-4 inline-block">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Jenis Produk </label>
                                <input type="text"
                                    name="produk"
                                    class="input-produk border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="" readonly required/>
                            </div>
                        </div>

                        <div class="w-5/12 lg:w-5/12 px-4 inline-block">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Qty POSTO (Kg.) </label>
                                <input type="number"
                                    name="qty"
                                    class="input-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="" readonly required/>
                            </div>
                        </div>

                        <div class="w-5/12 lg:w-5/12 px-4 inline-block">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Tanggal Terbit </label>
                                <input type="date"
                                    name="terbit"
                                    class="input-tgl-terbit border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="" readonly required/>
                            </div>
                        </div>

                        <div class="w-5/12 lg:w-5/12 px-4 mb-5 inline-block">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Tanggal Expired </label>
                                <input type="date"
                                    name="expired"
                                    class="input-tgl-expired border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="" readonly required/>
                            </div>
                        </div>

                        <div class="w-full lg:w-12/12 px-4" >
                            <div class="flex justify-center w-full">
                                <input type="submit"
                                    class="btn-simpan cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                    value="Simpan" disabled/>
                            </div>
                        </div>
                    </section>
                </form>

                <!-- FORM POSTO -->
                <form id="form-so-new" autocomplete="off" class="form-so-new w-full p-5 m-5 border-2 border-amber-500 rounded hidden">
                    <input type="hidden" class="input-posto" name="posto" value="">
                    <input type="hidden" class="counter" name="counter" value=0>
                    <section id="section-load">
                        <div class="w-full text-center px-4 mb-5 font-bold text-3xl">
                            <h1>LOADS</h1>
                        </div>

                        <div class="w-5/12 m-2 inline-block">
                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="grid-password"> Load ID </label>
                                    <input type="text"
                                        name="load"
                                        class="input-load border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="" readonly/>
                                </div>
                            </div>

                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="grid-password"> Booking Code </label>
                                    <input type="text"
                                        name="booking"
                                        class="input-booking border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="" readonly/>
                                </div>
                            </div>

                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="grid-password"> No. DO </label>
                                    <input type="text"
                                        name="do"
                                        class="input-do border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="" readonly/>
                                </div>
                            </div>

                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="grid-password"> Pick Up Date </label>
                                    <input type="date"
                                        name="pickup"
                                        class="input-pickup border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="" readonly/>
                                </div>
                            </div>

                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="grid-password"> Remark </label>
                                    <input type="text"
                                        name="remark"
                                        class="input-remark border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value="TIDAK ADA" readonly/>
                                </div>
                            </div>

                            <div class="w-full lg:w-12/12 px-4" >
                                <div class="flex justify-center w-full">
                                    <input type="submit"
                                        class="btn-add rounded-full cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                        value=" + " disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="w-5/12 m-2 inline-block border-2 p-5 rounded h-72 overflow-auto input-load-list">
                            <!-- List Load ID -->
                            <div class="grid grid-cols-2 gap-2 mb-5 load-list-0">
                                <input type="hidden" name="loads[0]">
                                <input type="hidden" name="bookings[0]">
                                <div><b>6257748329</b><br>SISTRO_BHP_gUkh6VBQ8</div>
                                <div id="0" class="cursor-pointer text-3xl w-1 load-delete"><i class="fas fa-times"></i></div>
                                <hr>
                            </div>
                        </div>
                        <div class="w-full lg:w-12/12 px-4" >
                            <div class="flex justify-center w-full">
                                <input type="submit"
                                    class="btn-simpan cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                    value="Simpan" disabled/>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="dot-elastic"></div>
@endsection