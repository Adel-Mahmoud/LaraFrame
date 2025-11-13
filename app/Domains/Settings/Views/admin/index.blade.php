@extends('layouts.master',['titlePage'=>$titlePage])

@section('css')
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection

<x-page-header :titlePage="$titlePage" />

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المشروع</label>
                            <input type="text" name="project_name" class="form-control"
                                value="{{ old('project_name', $settings->project_name ?? '') }}" required>
                        </div>

                        <div class="col-md-6 mb-3 phone">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="tel" name="phone" id="phone" class="form-control"
                                value="{{ old('phone', $settings->phone ?? '') }}" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">شرح قصير</label>
                            <textarea name="short_description" rows="3" class="form-control" required>{{ old('short_description', $settings->short_description ?? '') }}</textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $settings->address ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">شعار المشروع (Logo)</label>
                            <input type="file" name="logo" class="dropify" data-height="150"
                                data-default-file="{{ isset($settings->logo) ? asset('storage/' . $settings->logo) : '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">صورة البراند (Brand)</label>
                            <input type="file" name="brand_image" class="dropify" data-height="150"
                                data-default-file="{{ isset($settings->brand_image) ? asset('storage/' . $settings->brand_image) : '' }}">
                        </div>

                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="submit btn btn-primary d-inline-flex align-items-center gap-3"> حفظ التغييرات</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
@endsection