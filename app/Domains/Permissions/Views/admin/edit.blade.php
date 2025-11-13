@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الصلاحية</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $permission->name) }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Guard Name (اختياري)</label>
                            <input type="text" name="guard_name" class="form-control" value="{{ old('guard_name', $permission->guard_name) }}">
                            @error('guard_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">تحديث الصلاحية</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


