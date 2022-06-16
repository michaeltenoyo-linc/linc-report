@extends('smart.layouts.admin-layout')

@section('title')
Linc | Register Surat Jalan
@endsection

@section('header')
@include('smart.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-center">
                    <h1 class="text-xl text-blueGray-700">
                        Detail Surat Jalan SMART
                    </h1>
                    <h1 class="font-semibold text-3xl text-blueGray-700">
                        {{ str_replace('$',' [ DO : ',$suratjalan->id_so)." ]" }}
                    </h1>
                </div>
            </div>
        </div>
        <div class="p-8 ">
            <form id="form-so-new" autocomplete="off">
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> SO Information </h6>
                <div class="relative">
                    <div class="w-full lg:w-12/12 px-4 grid grid-cols-2 gap-4">
                        <div class="w-full p-2 grid grid-cols-2 gap-2 border-dashed border-r-2 border-black">
                            <div>
                                <b>
                                    Load ID <br>
                                    Tanggal Surat Jalan <br>
                                    Tanggal Serah SJ <br>
                                    Penerima <br>
                                    Customer Type
                                </b>
                            </div>
                            <div>
                                : {{ $suratjalan->load_id }} <br>
                                : {{ $suratjalan->tgl_terima }} <br>
                                : {{ $suratjalan->tgl_setor_sj }} <br>
                                : {{ $suratjalan->penerima }} <br>
                                : {{ strtoupper($suratjalan->customer_type) }}
                            </div>
                        </div>
                        <div class="w-full p-2 grid grid-cols-2 gap-2">
                            <div>
                                <b>
                                    Vehicle Number <br> 
                                    Tipe Aktual <br> 
                                    Tipe Blujay <br> 
                                    Driver <br> 
                                </b>
                            </div>
                            <div>
                                : {{ $suratjalan->nopol }} <br>
                                : {{ $truck->type }} <br>
                                : {{ str_replace('_',' ',$load->equipment_description) }} <br>
                                : {{ $suratjalan->driver_name}}
                            </div>
                        </div>
                    </div>
                    

                    <div class="w-full lg:w-12/12 px-4 py-8">
                        <div class="block w-full  overflow-x-auto">
                            <!-- Items table -->
                            <table id="yajra-datatable-so-items-list" class="items-center w-full bg-transparent border-collapse yajra-datatable-so-items-list">
                                <thead>
                                <tr>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Material Code
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Description
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Qty.
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Retur
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Gross Weight
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                        Subtotal Weight
                                    </th>
                                    <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="so-items-list-body">
                                    @foreach ($dload as $d)
                                        @foreach ($items as $i)
                                            @if ($i->material_code == $d->material_code)
                                                <tr>
                                                    <td class="px-6">{{ $i->material_code }}</td>
                                                    <td class="px-6">{{ $i->description }}</td>
                                                    <td class="px-6">{{ $d->qty }}</td>
                                                    <td class="px-6">{{ $d->retur }}</td>
                                                    <td class="px-6">{{ $i->gross_weight }}</td>
                                                    <td class="px-6">{{ $d->subtotal_weight }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="w-full px-6">
                        <b>Note : </b>{{ $suratjalan->note }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dot-elastic"></div>
@endsection
