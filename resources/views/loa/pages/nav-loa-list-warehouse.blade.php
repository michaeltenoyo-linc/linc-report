@extends('loa.layouts.admin-layout')

@section('title')
Linc | List LOA Warehouse
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
                        Letter of Agreement - WAREHOUSE
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 ">
            <div class="flex flex-wrap w-full">
                <div class="w-full lg:w-12/12 px-4 mb-8">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name"> Customer </label>
                        <input type="text"
                            name="customer"
                            class="input-customer border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value=""
                            list="warehouse-customers"/>
                        
                        <datalist id="warehouse-customers">
                            @foreach ( $warehouse_cust as $c)
                                <option value="{{ $c->customer }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4 mb-8">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password">Periode Aktif</label>
                        <input type="checkbox" name="aktif" class="" checked>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4 mb-8">
                    <hr>
                </div>

                <!-- LIST TABEL LOA -->

                <table id="yajra-datatable-warehouse-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-warehouse-list">
                    <thead>
                      <tr>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Nama Customer
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Lokasi
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Periode
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
