@extends('layouts.master2')

@section('css')
<link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid" dir="ltr">
    <div class="row no-gutter">
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="{{ config('settings.brand_image') ? asset('storage/' . config('settings.brand_image')) : URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="شعار الدخول">
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
            <div class="login d-flex align-items-center py-2">
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                            <div class="card-sigin">
                                <div class="mb-5 d-flex justify-content-center align-items-center">
                                    <img src="{{ config('settings.logo') ? asset('storage/' . config('settings.logo')) : URL::asset('assets/img/brand/favicon.png') }}" class="sign-favicon ht-40" alt="الشعار">
                                    <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{ config('settings.project_name') }}</span></h1>
                                </div>
                                <div class="card-sigin">
                                    <div class="main-signup-header">
                                        <h2>مرحباً بعودتك!</h2>
                                        <h5 class="font-weight-semibold mb-4">يرجى تسجيل الدخول للمتابعة</h5>
                                        <form method="POST" action="{{ route('admin.login.submit') }}">
                                            @csrf
                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif
                                            <div class="form-group">
                                                <label>البريد الإلكتروني</label>
                                                <input class="form-control" name="email" placeholder="أدخل بريدك الإلكتروني" type="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label>كلمة المرور</label>
                                                <input class="form-control" name="password" placeholder="أدخل كلمة المرور" type="password" required>
                                            </div>
                                            <button class="btn btn-main-primary btn-block submit d-flex justify-content-center align-items-center gap-2">
                                                تسجيل الدخول
                                                &nbsp;
                                            </button>
                                        </form>
                                        <!-- <div class="main-signin-footer mt-5">
                                            <p><a href="#">هل نسيت كلمة المرور؟</a></p>
                                            <p>لا تملك حساباً؟ <a href="#">أنشئ حساب جديد</a></p>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection