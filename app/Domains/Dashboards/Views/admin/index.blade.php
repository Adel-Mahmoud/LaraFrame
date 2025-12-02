@extends('layouts.master')
<x-page-header titlePage="الرئيسية" />

@section('css')
<link href="{{URL::asset('assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/custom/css/dashboard.css')}}" rel="stylesheet">
@endsection

@section('content')
@can('view dashboard')
<!-- row -->
<div class="card">
    <div class="card-body">
        <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="شعار الدخول">
    </div>
</div>
<!-- row closed -->

<!-- row closed -->
@else
<div class="card">
    <div class="card-body">
        <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="شعار الدخول">
    </div>
</div>
@endcan
@endsection

@section('js')
<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('assets/custom/js/dashboard.js')}}"></script>
@endsection