@extends('pkg.layouts.admin-layout')

@section('title')
Linc | Ticket Detail
@endsection

@section('header')
@include('pkg.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-center">
                    <h1 class="text-xl text-blueGray-700">
                        Detail Ticket PKG
                    </h1>
                    <h1 class="font-semibold text-3xl text-blueGray-700">
                        {{ $ticket->posto }}
                    </h1>
                </div>
            </div>
        </div>
        <div class="p-8 ">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> Ticket Information </h6>
            <div class="relative">
                <div class="w-full lg:w-12/12 px-4 grid grid-cols-2 gap-4">
                    <div class="w-full p-2 grid grid-cols-2 gap-2 border-dashed border-r-2 border-black">
                        <div>
                            <b>
                                POSTO <br>
                                Tujuan <br>
                                Terbit <br>
                                Expired <br>
                                Produk <br>
                                QTY Ticket <br>
                                
                            </b>
                        </div>
                        <div>
                            : {{ $ticket->posto }} <br>
                            : {{ $ticket->tujuan }} <br>
                            : {{ $ticket->terbit }} <br>
                            : {{ $ticket->expired }} <br>
                            : {{ $ticket->produk }} <br>
                            : {{ $ticket->qty }} <br>
                        </div>
                    </div>
                    
                </div>
                
                @php
                    $balance = $ticket->qty;
                @endphp
                
                <div class="w-full flex flex-col mt-5 px-4 py-8 grid grid-cols-3 gap-2">
                    @foreach ($booking as $b)   
                        @foreach ($performance as $p)
                            @if ($b->load_id == $p->tms_id)
                                @php
                                    $balance -= $p->weight_kg;
                                @endphp
                                    <div class="m-auto h-auto w-full max-w-md bg-white shadow p-2 border-t-4 border-green-600 rounded">
                                        <header class="p-2 border-b border-dashed flex"> 
                                            <div class="w-9/12">
                                                <h4 class="text-xs font-semibold">{{ $b->booking_code }}</h4>
                                                <h1 class="text-2xl font-mono text-green-600">{{ $b->load_id }}</h1>
                                                <h1 class="text-xs font-mono text-green-600">[ {{ $b->no_do }} ]</h1>
                                            </div>
                                            <div class="w-3/12">
                                                @if($b->remark != "TIDAK ADA")
                                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                        <i class="far fa-bookmark"></i>
                                                    </button>
                                                @endif
                                                
                                            </div>
                                        </header>
                                        <div class="flex flex-wrap p-2 w-full gap-4">
                                            <div class="flex flex-col w-full">
                                                <h4 class="text-xs">Vehicle Number</h4>
                                                <h1 class="text-lg">{{ $p->vehicle_number }}</h1>
                                            </div>
                                
                                            <div class="flex flex-col w-full">
                                                <h4 class="text-xs">Pickup Date</h4>
                                                <h1 class="text-md">{{ $b->pickup }}</h1>
                                            </div>
                                
                                            <div class="flex flex-col">
                                                <h4 class="text-xs">Weight (KG)</h4>
                                                <h1 class="text-md font-thin">{{ $p->weight_kg }}</h1>
                                            </div>

                                            <div class="flex flex-col">
                                                <h4 class="text-xs">Balance (KG)</h4>
                                                <h1 class="text-md font-thin">{{ $balance }}</h1>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            
            </div>
        </div>
    </div>
</div>

<div class="dot-elastic"></div>
@endsection
