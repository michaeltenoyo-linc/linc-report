@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="page-content" id="page-content" value="list-loa-master">
    <div class="relative break-words w-full mb-6 shadow-lg rounded bg-white p-10">
        <div class="w-full mb-10 text-center font-bold text-2xl">
            <h1>{{ $type }}</h1>
            <input type="hidden" name="type" id="loa_type_raw" value="{{ $type_raw }}">
        </div>
        <div class="w-full">
            <!-- LIST TABEL LOA -->
            <table id="yajra-datatable-loa-list" class="items-center w-full bg-transparent yajra-datatable-loa-list">
                <thead>
                <tr>
                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                        Reference
                    </th>
                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                        Customer
                    </th>
                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                        Latest LOA
                    </th>
                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                        Total LOA
                    </th>
                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody class="text-xs">
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
