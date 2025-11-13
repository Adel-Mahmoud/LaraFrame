@extends('layouts.master')
<x-page-header titlePage="لوحة التحكم" />
@section('content')
<!-- row -->
<div class="row">
    <div class="text-center">
        <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="الخلفية">
    </div>
</div>
@endsection
@section('js')
@endsection