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
        <div class="flex flex-nowrap p-8 text-center">
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

        <!-- FILES AREA -->
        <div class="flex flex-nowrap p-4 text-center">
        @for ($i=0; $i<$filesCount; $i++)
            <div class="inline-block w-full lg:w-2/12 px-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">FILES {{ $i+1 }}</button>
            </div>
        @endfor
        </div>
        
        <!-- FILES CONTAINER -->
        @for ($i=0; $i<$filesCount; $i++)
            @if ($filesFormat[$i] == "pdf")
                <div class="files files-{{$i}} flex flex-nowrap p-8 text-center">
                    <div id="pdf-viewer-{{$i}}" style="height: 800px;" class="w-full lg:w-12/12 px-4">
                        <!--PDF EMBED GOES HERE-->
                    </div>
                </div>
            @endif
        @endfor
    </div>
</div>

<!--PDF VIEWER-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@for($i=0; $i<$filesCount; $i++)
    @if ($filesFormat[$i] == "pdf")
        <script>
            PDFObject.embed("{{ route('show-pdf', ['filename' => $files[$i]]) }}", "#pdf-viewer-{{$i}}");
        </script>
    @endif
@endfor
@endsection

