@extends('loa.layouts.admin-layout')

@section('title')
Linc | List LOA
@endsection

@section('header')
@include('loa.components.header_no_login')
<style>
    
</style>
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center bg-red-600">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-white">
                        <i>CONFIDENTAL</i>
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <h1 class="font-bold text-lg text-black uppercase">
                    {{ $loa->customer }}
                </h1>
                <h1 id="transport-loa-periode" class="text-lg text-black uppercase">
                    ({{ $periode }})
                </h1>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <hr>
            </div>
        </div>
        <!-- INPUT RUTE BARU -->
        <div class="relative p-8">
            <form id="form-dloa-transport" class="hidden" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" class="ctrOtherName" name="ctrOtherName" value="0">
                <input type="hidden" name="ctrOtherRate" class="ctrOtherRate" value="0">
                <input type="hidden" name="id_loa" class="input-id-loa" value="{{ $loa->id }}">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> Routes Information </h6>
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="w-full mb-3">
                            <label class="uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Lokasi</label>
                            <input type="text"
                                required
                                name="lokasi"
                                class="input-lokasi border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""/>
                        </div>
                    </div>

                    <div class="w-full lg:w-12/12 px-4 my-8">
                        <hr>
                    </div>

                    <div class="w-full lg:w-12/12 px-4">
                        <label class="uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password"> Detail Biaya </label>
                        <small style="color:red;">
                            *Jika biaya tidak ada di LOA, bisa dibiarkan "0"
                        </small>
                    </div>                    

                    <!--Biaya Tambahan Transport-->
                    <div class="transport w-full lg:w-12/12 px-4">
                        <div class="w-full mb-3 border-4 border-dashed border-blue-300 py-8 px-4">
                            <div class="inline-block w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Rate Kirim </label>
                                    <input type="number"
                                    min=0
                                    name="rate"
                                    class="input-rate border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="inline-block w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Multidrop </label>
                                    <input type="number"
                                    min=0
                                    name="multidrop"
                                    class="input-multidrop border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="inline-block w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Overnight </label>
                                    <input type="number"
                                    min=0
                                    name="overnight"
                                    class="input-overnight border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="inline-block w-full lg:w-12/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Loading </label>
                                    <input type="number"
                                    min=0
                                    name="loading"
                                    class="input-loading border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="0"/>
                            </div>

                            <div class="other-rate-container-transport">

                            </div>

                            <div class="w-full lg:w-12/12 px-4 flex justify-center" >
                                <button class=" btn-tambahan bg-blue-500 rounded-full h-12 w-12 flex items-center justify-center">+</button>
                            </div>
                            <div class="w-full lg:w-12/12 px-4 flex justify-center" >
                                <small style="color:red;text-align: center;">*Detail tambahan biaya yang kompleks tidak perlu ditambahkan<br>dapat dilihat melalui file LOA yang diupload.</small>    
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <!-- END RUTE BARU -->

        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <hr>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <!-- LIST TABEL RUTE DAN UNIT TRANSPORT -->
                <input type="hidden" name="id_loa" id="id_loa" value="{{ $loa->id }}">
                <table id="yajra-datatable-dtransport-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-dtransport-list">
                    <thead>
                      <tr>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Unit
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Rute Awal
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Rute Akhir
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Rate
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

        <!-- FILES AREA -->
        <div class="w-full p-8 text-center border">
            <div class="w-full p-8 font-bold text-lg">
                Files LOA
            </div>
            <div class="grid grid-cols-4 gap-4">
                @for ($i=0; $i<$filesCount; $i++)
                    <button value="{{$i}}" class="btn-nav-files bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ $i+1 }} : {{ explode('.',explode('-',$files[$i])[2])[0] }}</button>
                @endfor
            </div>
        </div>
        
        <!-- FILES CONTAINER -->
        @for ($i=0; $i<$filesCount; $i++)
            @if ($filesFormat[$i] == "pdf")
                <div class="files files-{{$i}} flex flex-nowrap py-8 px-4 text-center hidden">
                    <div id="pdf-viewer-{{$i}}" style="height: 800px;" class="w-full lg:w-12/12 px-4">
                        <!--PDF EMBED GOES HERE-->
                    </div>
                </div>
            @elseif ($filesFormat[$i] == "png")
                <div class="files files-{{$i}} flex flex-nowrap py-8 px-4 object-center hidden">
                    <!--IMAGE EMBED GOES HERE-->
                    <img id="img-viewer-{{$i}}" src="{{ route('show-png', ['filename' => $files[$i], 'content_path' => 'loa_transport']) }}" alt="image not found." class="w-1/2 px-4 rounded-lg image-loa">
                </div>
            @elseif ($filesFormat[$i] == "xlsx")
                <div class="files files-{{$i}} py-8 px-4 text-center hidden">
                    <h1 style="color:red;" class="w-full">*Sorry, browser is not supported to show excel's file.</h1>
                    <h3 style="color:red;" class="w-full mb-4">IF YOU WANT TO SEE PLEASE DOWNLOAD THE FILE BELOW.</h3>
                    <!--IMAGE EMBED GOES HERE-->
                    <a target="_blank" href="{{ route('show-xlxs', ['filename' => $files[$i], 'content_path' => 'loa_transport']) }}"><button class="btn_yellow">Download</button></a>
                </div>
            @endif
        @endfor

    </div>
</div>

<!--PDF VIEWER-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@for($i=0; $i<$filesCount; $i++)
    @if ($filesFormat[$i] == "pdf")
        <script>
            PDFObject.embed("{{ route('show-pdf', ['filename' => $files[$i], 'content_path' => 'loa_transport']) }}", "#pdf-viewer-{{$i}}");
        </script>
    @endif
@endfor
@endsection


@include('loa.modals.loa-transport-modal-local')