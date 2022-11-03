@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Report
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="page-content" id="page-content" value="loa-generate-report">
    <div class="relative break-words w-full mb-6 shadow-lg rounded bg-white p-10">
        <div class="w-full mb-5">
            <center class="font-bold text-2xl">
                Generate LOA Report
            </center>
        </div>

        <form id="loa-generate-report" class="relative w-full" autocomplete="off">
            <div class="w-full grid grid-cols-2 gap-4">
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="constraint">Division</label>
                    <select required name="division" id="input-division" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                        <option value="bp">Bahana Prestasi</option>
                        <option value="cml">Cipta Mapan</option>
                    </select>
                </div>
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="status">Customer</label>
                    <select required name="customer" id="input-customer" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" type="text">
                        <option value="all">==Semua==</option>
                    </select>
                </div>
            </div>
            <div class="w-full grid grid-cols-2 gap-4">
                <div class="flex inline-block w-full mb-5">
                    <input id="archive-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="archive-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Show Archive</label>
                </div>
                <div class="flex inline-block w-full mb-5 justify-end">
                    <button type="submit" class="btn-generate-report text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Generate
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
