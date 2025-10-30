@extends('layouts.admin')

{{-- Page header section with dashboard title --}}
@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

{{-- Main dashboard content section --}}
@section('content')
@php
    $locations = [
        ['lat' => 10.7769, 'lng' => 106.7009, 'name' => 'TP.HCM'],
        ['lat' => 16.0544, 'lng' => 108.2022, 'name' => 'Đà Nẵng'],
        ['lat' => 15.8700, 'lng' => 108.3380, 'name' => 'Quảng Nam'],
    ];
@endphp

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 h-[500px]">
    <x-map-view :locations="$locations" :zoom="7" />
</div>

@endsection