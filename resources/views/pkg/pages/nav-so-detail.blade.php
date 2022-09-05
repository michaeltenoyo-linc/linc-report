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
            <form id="form-so-new" autocomplete="off">
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

                    <div class="w-full lg:w-12/12 px-4 py-8">
                        <div class="block w-full  overflow-x-auto">
                            <!-- Items table -->
                            <table id="yajra-datatable-so-items-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-so-items-list">
                                <thead>
                                <tr>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                       Load ID
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        DO
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Booking Code
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Pickup Date
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Vehicle Number
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Quantity (KG)
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Balance
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Remark
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="so-items-list-body">
                                    @foreach ($booking as $b)
                                        @foreach ($performance as $p)
                                            @if ($b->load_id == $p->tms_id)
                                                @php
                                                    $balance -= $p->weight_kg;
                                                @endphp
                                                <tr>
                                                    <td class="px-6">{{ $b->load_id }}</td>
                                                    <td class="px-6">{{ $b->no_do }}</td>
                                                    <td class="px-6">{{ $b->booking_code }}</td>
                                                    <td class="px-6">{{ $b->pickup }}</td>
                                                    <td class="px-6">{{ $p->vehicle_number }}</td>
                                                    <td class="px-6">{{ $p->weight_kg }}</td>
                                                    <td class="px-6">{{ $balance }}</td>
                                                    <td class="px-6"><p>{{ $b->remark }}</p></td>                                                 
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dot-elastic"></div>
@endsection
