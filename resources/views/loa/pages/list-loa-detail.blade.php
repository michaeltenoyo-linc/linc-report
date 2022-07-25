@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')

<style>
    .content{
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' version='1.1' height='100px' width='100px'><text transform='translate(20, 100) rotate(-45)' fill='rgb(245,45,45, 0.2)' font-size='15'>Linc Group</text></svg>");
    }
</style>
@endsection

@section('content')
<input type="hidden" name="page-content" id="page-content" value="list-loa-detail">
<div class="w-full mb-12 px-4">
    <div class="relative content p-10 flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="w-full bg-gradient-to-r from-red-700 to-red-300 p-2 text-white font-bold italic text-sm">
            CONFIDENTAL
        </div>
        <div class="w-full mb-10 flex h-48 items-center">
            <div class="w-2/12 text-center">
                @if (file_exists(public_path().'/assets/icons/customers/'.$customer->reference.'.png'))
                    <img src="{{ asset('/assets/icons/customers/'.$customer->reference.'.png') }}">
                @else
                    <img src="{{ asset('/assets/icons/customers/default.png') }}">
                @endif
            </div>
            <div class="w-10/12 text-center">
                <div class="text-lg" id="customer_reference">{{ $customer->reference }}</div>
                <div class="font-bold text-3xl" ><u id="customer_name">{{ $customer->name }}</u></div>
                <div class="uppercase" id="loa_type">{{ $customer->type_full }}</div>
                <input type="hidden" name="type" id="loa_type_short" value="{{ $customer->type }}">
            </div>
        </div>
        
        <!-- LOA Sub-Group Tab -->
        <input type="hidden" name="" id="selected-timeline" value="">
        <div class="w-full ml-2">
            <ul id="tab-container" class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <!-- Tab List Items -->
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-active">Profile</a>
                </li>
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-inactive">Dashboard</a>
                </li>
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-inactive">Settings</a>
                </li>
                <li class="mr-2 tab-content">
                    <a href="#" class="tab-inactive">Contacts</a>
                </li>
            </ul>
        </div>

        <!--Tab Content-->
        <div class="w-full flex">
            <div class="w-8/12 p-5 border-2 border-gray-500 rounded-lg mr-3">
                <div class="w-full mx-auto flex items-center justify-center mb-4">
                    <input id="loa-archive-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="loa-archive-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Show Archive</label>
                </div>
                <!--Archive Section-->
                <div class="bg-gray-200 mx-auto w-full">
                    <div class="relative wrap overflow-y-auto p-5 h-96">
                        <div class="border-2-2 absolute border-opacity-20 border-gray-700 h-full border" style="left: 30%"></div>
                        
                        <div id="timeline-list">
                            <!-- timeline list items -->
                            <div class="mb-12 flex justify-between items-center w-full">
                                <div class="w-1">
    
                                </div>
                                <div class="z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">
                                    <h1 class="mx-auto font-semibold text-lg text-right text-white">1</h1>
                                </div>
                                <div id="timeline-context" class="timeline cursor-pointer order-1 bg-gray-400 hover:bg-gray-300 rounded-lg shadow-xl w-10/12 px-6 py-4">
                                    <h3 class="mb-3 font-bold text-gray-800 text-xl">Context Title</h3>
                                    <p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">
                                        <b class="text-gray-800">Effective :</b> DD/MM/YYYY <b class="text-gray-800">| Expired :</b> DD/MM/YYYY
                                    </p>
                                </div>
                            </div>

                            <div class="mb-8 flex justify-between flex-row-reverse items-center w-full left-timeline">
                                <div class="order-1 w-5/12"></div>
                                <div class="z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">
                                  <h1 class="mx-auto text-white font-semibold text-lg">2</h1>
                                </div>
                                <div class="order-1 bg-red-400 rounded-lg shadow-xl w-5/12 px-6 py-4">
                                  <h3 class="mb-3 font-bold text-white text-xl">Lorem Ipsum</h3>
                                  <p class="text-sm font-medium leading-snug tracking-wide text-white text-opacity-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Archive Section-->
            </div>
            <div class="w-4/12 p-5 border-2 border-gray-500 rounded-lg">
                <input type="hidden" name="" id="selected-loa-id" value="">
                <div class="w-full text-center font-bold text-xl mb-5" id="file-group-name">
                    << Choose a Context >>
                </div>
                <div class="w-full flex justify-center overflow-y-auto h-64">
                    <ul id="file-container" class="bg-white rounded-lg w-96 text-gray-900">
                        <!--Files Itemlist-->
                        <li class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">
                            <div class="w-full">File PDF kontrak full<span class="text-xs bg-red-700 text-white rounded p-1 ml-3">.PDF</span></div>
                        </li>
                        <li class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">
                            <div class="w-full">Detail Harga Rute<span class="text-xs bg-lime-700 text-white rounded p-1 ml-3">.XLSX</span></div>
                        </li>
                        <li class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">
                            <div class="w-full">Bukti Foto Struk DP<span class="text-xs bg-yellow-700 text-white rounded p-1 ml-3">.JPG</span></div>
                        </li>
                    </ul>
                </div>
                <div class="w-full">
                    <div class="w-12/12 my-5 flex justify-end">
                        <div></div>
                        <button id="" type="button" class="btn-delete-all-file text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <span class="mr-2">Delete All</span> <i class='fas fa-folder-plus'></i>
                        </button>
                        <button id="" type="button" class="btn-add-file text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span class="mr-2">Add File</span> <i class='fas fa-folder-plus'></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="w-full m-5 px-4">
            <div class="w-full text-center font-bold text-2xl px-4">
                File Viewer
            </div>
            <div class="w-full text-center text-red-500 px-4">
                Choose a file to show
            </div>
        </div>

        <!-- FILES CONTAINER -->
        <!-- PDF -->
        <div id="pdf" class="viewer-container flex flex-nowrap py-8 px-4 text-center hidden">
            <div id="pdf-viewer" style="height: 800px;" class="w-full lg:w-12/12 px-4">
                <!--PDF EMBED GOES HERE-->
            </div>
        </div>
        <!-- EXCEL -->
        <div id="excel" class="w-full viewer-container flex flex-nowrap py-8 px-4 text-center justify-center hidden">
            <a id="open-excel" href="" target="_blank"><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Open File in New Tab</button></a>
        </div>
        <!-- IMAGE -->
        <div id="image" class="w-full viewer-container flex flex-nowrap py-8 px-4 text-center hidden justify-center">
            <img id="img-viewer" src="" alt="image not found." class="w-1/2 px-4 rounded-lg image-loa">
        </div>
        <!-- DOCX -->
        <div id="docx" class="viewer-container flex flex-nowrap py-8 px-4 text-center hidden">

        </div>
        <!-- MSG -->
        <div id="msg" class="w-full viewer-container flex flex-nowrap py-8 px-4 text-center justify-center hidden">
            
        </div>
    </div>
</div>
@endsection

@include('loa.modals.loa-add-file');