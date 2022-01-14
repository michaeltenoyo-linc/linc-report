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
        <div class="p-8 ">
            <form id="form-search-billable" autocomplete="off" enctype="multipart/form-data">
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Nama Customer</label>
                        <input name="customer" class="input-customer border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text" list="customers">
                        <datalist id="customers">
                            @foreach ($transport_cust as $c)
                                <option value="{{ $c->customer }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <!--RUTE AWAL-->
                <div class="inline-block w-full lg:w-5/12 px-4">
                    <div class="relative w-full mb-3">
                        @php
                            $provinces = new App\Http\Controllers\IndonesiaDropdownController;
                            $provinces= $provinces->provinces();
                        @endphp
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Provinsi Awal</label>
                        <select required id="provinsi1" name="provinsi1" class="input-route-start border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                            <option value="-1">==Pilih Salah Satu==</option>
                            @foreach ($provinces as $item)
                                <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Kota Awal</label>
                        <select required id="kota1" name="kota1" class="input-route-start border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                            <option value="-1">==Pilih Salah Satu==</option>
                        </select>
                    </div>
                </div>

                <!--RUTE AKHIR-->
                <div class="inline-block w-full lg:w-5/12 px-4">
                    <div class="relative w-full mb-3">
                        @php
                            $provinces = new App\Http\Controllers\IndonesiaDropdownController;
                            $provinces= $provinces->provinces();
                        @endphp
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Provinsi Tujuan</label>
                        <select required id="provinsi2" name="provinsi2" class="input-route-start border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                            <option value="-1">==Pilih Salah Satu==</option>
                            @foreach ($provinces as $item)
                                <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Kota Tujuan</label>
                        <select required id="kota2" name="kota2" class="input-route-start border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                            <option value="-1">==Pilih Salah Satu==</option>
                        </select>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4" >
                    <div class="flex flex-row-reverse w-full mb-3">
                        <input type="submit"
                            class="input-submit bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                            value="Cari"/>
                    </div>
                </div>
            </form>

            <div class="w-full lg:w-12/12 my-4">
                <div class="relative w-full">
                    <hr>
                </div>
            </div>

            <!-- SHOW ROUTE INFORMATION -->

            <div class="inline-block w-full lg:w-5/12 px-4">
                <div class="relative w-full mb-3">
                    <!--START-->
                    <div id="container-route-start">

                    </div>
                </div>
            </div>

            <div class="inline-block w-full lg:w-5/12 px-4">
                <div class="relative w-full mb-3">
                    <!--END-->
                    <div id="container-route-end">

                    </div>
                </div>
            </div>

            <div class="w-full lg:w-12/12 my-4">
                <div class="relative w-full">
                    <hr>
                </div>
            </div>

            <!-- Detail LOA Search Result -->
            <div class="w-full lg:w-12/12 my-4">
                <div class="relative w-full">
                    <table id="table-warehouse-detail" class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                          <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">ID</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Rute Awal</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Rute Akhir</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Unit</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left"></div>
                            </th>
                          </tr>
                        </thead>
                        <tbody id="content-dloa-list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Dependent Indonesia Dropdown-->
<script>
</script>
@endsection
@include('loa.modals.loa-transport-modal')