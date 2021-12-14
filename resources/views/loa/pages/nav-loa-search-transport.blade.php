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
            <form id="form-loa-new" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" class="ctrOtherName" name="ctrOtherName" value="0">
                <input type="hidden" name="ctrOtherRate" class="ctrOtherRate" value="0">
                <input type="hidden" name="inputDivision" class="input-division" value="transport">
                <input type="hidden" name="ctrOtherUomWarehouse" class="ctrOtherUomWarehouse" value="7">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> LOA Information </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Nama Customer</label>
                            <input required name="customer" class="input-divisi border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text" list="customers">
                            <datalist id="customers">
                                <option value="smart">[ALL] Sinar Mas Agro Resources and Technology (SMART)</option>
                                <option value="smart mt">[MT] Sinar Mas Agro Resources and Technology (SMART)</option>
                                <option value="smart consumer">[CONSUMER] Sinar Mas Agro Resources and Technology (SMART)</option>
                                <option value="smart pallet">[PALLET] Sinar Mas Agro Resources and Technology (SMART)</option>
                                <option value="smart ecom">[E-COM] Sinar Mas Agro Resources and Technology (SMART)</option>
                                <option value="smart industrial">[E-COM] Sinar Mas Agro Resources and Technology (SMART)</option>
                                <option value="ltl">Lautan Luas (LTL)</option>
                                <option value="permata agro">Permata Agro</option>
                                <option value="nl">Nirwana Lestari (NL)</option>
                                <option value="gcm">GCM Marketing Solutions Indonesia</option>
                                <option value="cli">Cipta Logistik Indonesia (CLI)</option>
                                <option value="tiv">Tirta Investama</option>
                                <option value="cmd">Cipta Mandiri Logistik (CMD)</option>
                                <option value="indocement">Indocement</option>
                                <option value="hasa prima">Hasa Prima</option>
                                <option value="sankyo">Sankyo Coorporation</option>
                                <option value="bhp">Bahana Prestasi</option>
                                <option value="ssi prima mas">SSI Prima Mas</option>
                                <option value="pmm">Prima Mas Makmur</option>
                                <option value="viston">Viston Spesialisasi Indonesia</option>
                                <option value="pkt">Pupuk Kalimantan Timur</option>
                                <option value="lsh">Lam Seng Hang</option>
                                <option value="karel">Karel</option>
                                <option value="kargo tech">Kargo Technology</option>
                                <option value="ilc">ILC Logistics Indonesia</option>
                                <option value="eci">ECCO Indonesia</option>
                                <option value="eti">ECCO Tanery</option>
                                <option value="clm">CLEMENTROP</option>
                                <option value="bdp">BDP Indonesia</option>
                            </datalist>
                        </div>
                    </div>

                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Periode Mulai</label>
                            <input type="date"
                                required
                                name="periode_start"
                                class="input-periode-start border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Periode Akhir</label>
                            <input type="date"
                                required
                                name="periode_end"
                                class="input-periode-end border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <!-- INPUT DETAIL

                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Rute Awal</label>
                            <input type="text"
                                required
                                name="route_start"
                                class="input-route-start border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Rute Akhir</label>
                            <input type="text"
                                required
                                name="route_end"
                                class="input-route-end border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Unit</label>
                            <input required name="unit" class="input-divisi border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text" list="units">
                            <datalist id="units">
                                <option value="L300"></option>
                                <option value="JUMBO"></option>
                                <option value="BU"></option>
                                <option value="CDE"></option>
                                <option value="CDD"></option>
                                <option value="FUSO"></option>
                                <option value="Tronton"></option>
                                <option value="Trailer"></option>
                                <option value="Trailer 20' + Container"></option>
                                <option value="Trailer 40' + Container"></option>
                                <option value="Wing Box"></option>
                            </datalist>
                        </div>
                    </div>

                    -->

                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Divisi </label>
                            <select
                                name="divisi" 
                                id="input-divisi" 
                                class="input-divisi border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                <option value="transport">Transport</option>
                            </select>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4 my-8">
                        <hr>
                    </div>

                    <!-- Detail Biaya

                    <div class="w-full lg:w-12/12 px-4">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Detail Biaya </label>
                        <small style="color:red;">
                            *Jika biaya tidak ada di LOA, bisa dibiarkan "0"
                        </small>
                    </div>                    

                    
                    <div class="warehouse w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3 border-4 border-dashed border-blue-300 py-8 px-4">
                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Rate Pengiriman </label>
                                    <input type="number"
                                    min=0
                                    name="kirim"
                                    class="input-kirim border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[0]"
                                    class="input-uom0 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="TBD"
                                    list="uom"/>
                            </div>

                            <div class="other-rate-container">

                            </div>

                            <div class="w-full lg:w-12/12 px-4 flex justify-center" >
                                <button class=" btn-tambahan bg-blue-500 rounded-full h-12 w-12 flex items-center justify-center">+</button>
                            </div>
                            <div class="w-full lg:w-12/12 px-4 flex justify-center" >
                                <small style="color:red;text-align: center;">*Detail tambahan biaya yang kompleks tidak perlu ditambahkan<br>dapat dilihat melalui file LOA yang diupload.</small>    
                            </div>
                        </div>
                    </div>

                    <datalist id="uom">
                        <option value="/bulan">per bulan, per month</option>
                        <option value="/tahun">per tahun, per year</option>
                        <option value="/Sqm/Month">per Sqm per Bulan</option>
                        <option value="/PP/Activity">per PP per Activity</option>
                        <option value="/pcs/Month">per pieces per bulan</option>
                        <option value="/sqm">per square meter</option>
                        <option value="/cbm">per cubic meter</option>
                    </datalist>

                    -->

                    <div class="w-full lg:w-12/12 px-4 py-6" >
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Upload Scan PDF Letter of Agreement </label>
                        <input type="file"
                        accept="application/pdf"
                        name="filePDF"
                        class="input-file-pdf border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                        />
                        <small style="color:red;">*Tidak wajib, silahkan sesuaikan dengan format file LOA</small>
                    </div>

                    <div class="w-full lg:w-12/12 px-4 py-6" >
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Upload Scan IMAGES Letter of Agreement </label>
                        <input type="file"
                        accept="image/*"
                        name="fileImages"
                        class="input-file-images border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                        value="0"
                        multiple="multiple"/>
                        <small style="color:red;">*Tidak wajib, silahkan sesuaikan dengan format file LOA</small>
                    </div>

                    <div class="w-full lg:w-12/12 px-4 py-6" >
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Upload Scan Excel Letter of Agreement </label>
                        <input type="file"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                        name="fileExcel"
                        class="input-file-excel border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                        value="0"
                        multiple="multiple"/>
                        <small style="color:red;">*Tidak wajib, silahkan sesuaikan dengan format file LOA</small>
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
