@extends('smart.layouts.admin-layout')

@section('title')
Linc | SMART Homepage
@endsection

@section('header')
@include('smart.components.header_no_login')
@endsection

@section('content')
<div class="w-full mb-12 px-4">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-lg text-blueGray-700">
                        Home Page
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
