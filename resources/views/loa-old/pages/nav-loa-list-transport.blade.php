@extends('loa.layouts.admin-layout')

@section('title')
Linc | List LOA Transport
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Letter of Agreement - TRANSPORT
                    </h3>
                </div>
            </div>
        </div>
        <div class="p-8 ">
            <div class="w-full">
                <div class="w-full lg:w-12/12 px-4 mb-8">
                    <div class="relative w-full mb-3">
                        <label class="block-inline uppercase text-blueGray-600 pr-4 font-bold mb-2"
                            htmlFor="grid-password">Periode Aktif</label>
                        <input type="checkbox" name="aktif" class="" checked>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4 mb-8">
                    <hr>
                </div>

                <!-- LIST TABEL LOA -->
                <div class="block w-full lg:w-12/12 px-4 mb-8">
                    <div class="w-full mb-3">
                        <table id="yajra-datatable-transport-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-transport-list">
                            <thead>
                              <tr>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
        
                                </th>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                    Nama Customer
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
    </div>
</div>
@endsection
