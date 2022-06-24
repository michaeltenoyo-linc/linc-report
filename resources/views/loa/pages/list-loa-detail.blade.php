@extends('loa.layouts.admin-layout')

@section('title')
Linc | LOA Homepage
@endsection

@section('header')
@include('loa.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative p-10 flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="w-full text-center mb-10">
            <h1 class="text-lg">{{ $customer->reference }}</h1>
            <h1 class="font-bold text-3xl"><u>{{ $customer->name }}</u></h1>
            <h5 class="uppercase">{{ $customer->type_full }}</h5>
        </div>
        
        <div class="w-full grid grid-cols-3 gap-4">
            <div class="p-5">
                <center>
                    @if (file_exists(public_path().'/assets/icons/customers/'.$customer->reference.'.png'))
                        <img src="{{ asset('/assets/icons/customers/'.$customer->reference.'.png') }}">
                    @else
                        <img src="{{ asset('/assets/icons/customers/default.png') }}">
                    @endif
                </center>
            </div>
            <div class="p-5 border-2 border-gray-500 rounded-lg">
                Archive
            </div>
            <div class="p-5 border-2 border-gray-500 rounded-lg">
                Files
            </div>
        </div>
    </div>
</div>
@endsection