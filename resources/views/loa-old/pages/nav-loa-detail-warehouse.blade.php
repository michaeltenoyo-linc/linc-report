@extends('loa.layouts.admin-layout')

@section('title')
Linc | List LOA
@endsection

@section('header')
@include('loa.components.header_no_login')
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
                <h1 class="font-bold text-lg text-black uppercase">
                    [ {{ $loa->lokasi }} ]
                </h1>
                <h1 class="text-lg text-black uppercase">
                    ({{ $periode }})
                </h1>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 text-center detail-display">
            <div class="w-full lg:w-12/12 px-4">
                <!-- LIST TABEL LOA -->

                <table id="table-warehouse-detail" class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                      <tr>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Nama Biaya</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Rate</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">UoM</div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @for ($i=0; $i<$rateCount ;$i++)
                            <tr>
                                <td class="p-2 whitespace-nowrap text-left">{{ $rateName[$i] }}</td>
                                <td class="p-2 whitespace-nowrap text-left">Rp. {{ number_format(floatval($rate[$i]),2,',','.') }}</td>
                                <td class="p-2 whitespace-nowrap text-left">{{ $rateUom[$i] }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-nowrap p-8 text-center detail-edit hidden">
            <div class="w-full lg:w-12/12 px-4">
                <!-- LIST EDIT LOA -->
                <form id="form-loa-edit" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" class="ctrOtherName" name="ctrOtherName" value="0">
                    <input type="hidden" name="ctrOtherRate" class="ctrOtherRate" value="0">
                    <input type="hidden" name="inputDivision" class="input-division" value="warehouse">
                    <input type="hidden" name="ctrOtherUomWarehouse" class="ctrOtherUomWarehouse" value="7">
                    <div class="warehouse w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3 border-4 border-dashed border-blue-300 py-8 px-4">
                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Jasa Titip </label>
                                    <input type="number"
                                    min=0
                                    name="titip"
                                    class="input-titip border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->jasa_titip }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[0]"
                                    class="input-uom0 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[0] }}"
                                    list="uom"/>
                            </div>
                            
                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Handling In </label>
                                    <input type="number"
                                    min=0
                                    name="handling_in"
                                    class="input-handling-in border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->handling_in }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[1]"
                                    class="input-uom1 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[1] }}"
                                    list="uom"/>
                            </div>

                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Handling Out </label>
                                    <input type="number"
                                    min=0
                                    name="handling_out"
                                    class="input-handling-out border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->handling_out }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[2]"
                                    class="input-uom2 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[2] }}"
                                    list="uom"/>
                            </div>

                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Rental Pallete </label>
                                    <input type="number"
                                    min=0
                                    name="rental"
                                    class="input-rental border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->rental_pallete }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[3]"
                                    class="input-uom3 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[3] }}"
                                    list="uom"/>
                            </div>

                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Loading </label>
                                    <input type="number"
                                    min=0
                                    name="loading"
                                    class="input-loading border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->loading }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[4]"
                                    class="input-uom4 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[4] }}"
                                    list="uom"/>
                            </div>

                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Unloading </label>
                                    <input type="number"
                                    min=0
                                    name="unloading"
                                    class="input-unloading border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->unloading }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[5]"
                                    class="input-uom5 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[5] }}"
                                    list="uom"/>
                            </div>

                            <div class="inline-block w-full lg:w-9/12 px-4 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> Biaya Management </label>
                                    <input type="number"
                                    min=0
                                    name="management"
                                    class="input-management border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $loa->management }}"/>
                            </div>

                            <div class="inline-block w-full lg:w-2/12 mb-6" >
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password"> UoM </label>
                                    <input type="text"
                                    name="uom[6]"
                                    class="input-uom6 border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 "
                                    value="{{ $uom[6] }}"
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
                </form>
            </div>
        </div>

        <!-- Button Edit -->
        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <button value="edit" class="btn-edit-addcost bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit Detail</button>
            </div>
        </div>  

        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <hr>
            </div>
        </div>  

        <!-- FILES AREA -->
        <div class="flex flex-nowrap p-4 text-center">
        @for ($i=0; $i<$filesCount; $i++)
            <div class="inline-block w-full lg:w-2/12 px-4">
                <button value="{{$i}}" class="btn-nav-files bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">FILES {{ $i+1 }}</button>
            </div>
        @endfor
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
                <div class="files files-{{$i}} flex flex-nowrap py-8 px-4 text-center hidden">
                    <!--IMAGE EMBED GOES HERE-->
                    <img id="img-viewer-{{$i}}" src="{{ route('show-png', ['filename' => $files[$i], 'content_path' => 'loa_warehouse']) }}" alt="image not found." class="w-full lg:w-12/12 px-4">
                </div>
            @elseif ($filesFormat[$i] == "xlxs")
                <div class="files files-{{$i}} py-8 px-4 text-center hidden">
                    <h1 style="color:red;" class="w-full">*Sorry, browser is not supported to show excel's file.</h1>
                    <h3 style="color:red;" class="w-full mb-4">IF YOU WANT TO SEE PLEASE DOWNLOAD THE FILE BELOW.</h3>
                    <!--IMAGE EMBED GOES HERE-->
                    <a target="_blank" href="{{ route('show-xlxs', ['filename' => $files[$i], 'content_path' => 'loa_warehouse']) }}"><button class="btn_yellow">Download</button></a>
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
            PDFObject.embed("{{ route('show-pdf', ['filename' => $files[$i], 'content_path' => 'loa_warehouse']) }}", "#pdf-viewer-{{$i}}");
        </script>
    @endif
@endfor
@endsection

