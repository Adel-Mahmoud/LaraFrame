@extends('layouts.master',['titlePage'=>$titlePage])
<x-page-header :sectionPage="$sectionPage" :titlePage="$titlePage" />

@section('content')
<x-form
    :action="route('admin.users.index')"
    submitLabel="اضافة مستخدم جديد"
    cancelRoute="admin.users.index">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">الأدوار</label>
            <select name="roles[]" class="form-control" multiple required>
                @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

    </div>
</x-form>
@endsection