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
                <h1 class="text-lg text-black uppercase">
                    ({{ $periode }})
                </h1>
            </div>
        </div>
        <div class="flex flex-nowrap p-8 text-center">
            <div class="w-full lg:w-12/12 px-4">
                <!-- LIST TABEL RUTE DAN UNIT TRANSPORT -->
                
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

