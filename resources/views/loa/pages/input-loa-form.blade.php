@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <input type="hidden" name="page-content" id="page-content" value="input-loa-form">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="flex flex-nowrap">
            <div class="w-full p-10">
                <form id="form-loa-new" autocomplete="off">
                    <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> New Letter Of Agreements</h6>
                    <div class="flex flex-wrap">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Nama LOA <span class="text-red-500">*Bukan nama file, penamaan digunakan untuk judul pada archive history LOA customer</span> </label>
                                <input type="text"
                                    name="name"
                                    class="input-name border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value=""
                                    required/>
                            </div>

                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Sub-Folder LOA <span class="text-red-500">*Subgrup digunakan untuk memisahkan arsip kustomer melalui grup</span> </label>
                                <input type="text"
                                    name="group"
                                    class="input-group border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="Utama"
                                    list="list-group" required/>
                                
                                <datalist id="list-group">
                                    @foreach ($group_list as $g)
                                        <option value="{{ $g->group }}">{{ $g->name }} - {{ $g->group }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Customer <span class="text-red-500">*Jika customer belum terdaftar, harap hubungi admin server</span></label>
                                <input type="text"
                                    name="customer"
                                    class="input-customer border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value=""
                                    list="list-customer" required/>

                                <datalist id="list-customer">
                                    @foreach ($customer as $c)
                                        <option value="{{ $c->reference }}">{{ $c->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="name">Type</label>
                                <input type="text"
                                    name="type"
                                    class="input-type border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    value="{{ $type }}"
                                    required readonly/>
                            </div>

                            <div class="w-full grid grid-cols-2 gap-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Period Effective In</label>
                                    <input type="date"
                                        name="effective"
                                        class="input-effective border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Expired</label>
                                    <input type="date"
                                        name="expired"
                                        class="input-expired border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                            </div>

                            <hr class="my-5">
                            
                            <div class="w-full text-center mb-10">
                                <label class="block text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">FILE UTAMA<br><span class="text-red-500">*Upload 1 file utama, bila lebih dari satu dapat di upload setelah ini.</span></label>
                            </div>
                            <div class="w-full grid grid-cols-3 gap-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Filename</label>
                                    <input type="text"
                                        name="filename"
                                        class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Upload</label>
                                    <input type="file"
                                        name="file"
                                        class="input-file border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        value=""
                                        required/>
                                </div>
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlFor="name">Extension</label>
                                    <select
                                        name="extension"
                                        class="input-extension border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        required>
                                        <option value=".pdf">PDF (.pdf)</option>
                                        <option value=".docx">Office Word (.docm, .docx, .dot, .dotx)</option>
                                        <option value=".xlsx">Spreadsheet (.xlxs, .xlsm, .xlsb, .xltx, .xls)</option>
                                        <option value=".jpg">Image (.jpeg, .jpg, .png)</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-5">

                            <div class="w-full lg:w-12/12 px-4" >
                                <div class="flex flex-row-reverse w-full mb-3">
                                    <input type="submit"
                                        class="btn-simpan bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-right"
                                        value="Simpan"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
