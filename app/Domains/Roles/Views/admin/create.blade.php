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
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الدور</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        @php
                        $groupedPermissions = [];

                        foreach($permissions as $permission) {
                        $parts = explode(' ', $permission->name);

                        // إزالة الفعل إذا كان موجودًا في البداية
                        $verbs = ['view', 'create', 'edit', 'delete'];
                        if (in_array(strtolower($parts[0]), $verbs)) {
                        array_shift($parts);
                        }

                        $groupName = implode(' ', $parts);

                        $groupName = Str::plural(ucfirst($groupName));

                        $groupedPermissions[$groupName][] = $permission;
                        }
                        @endphp

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">الصلاحيات</label>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="checkAllPermissions">
                                <label class="form-check-label fw-semibold mr-3" for="checkAllPermissions">
                                    تحديد الكل
                                </label>
                            </div>

                            @foreach($groupedPermissions as $groupName => $groupPermissions)
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary text-capitalize">{{ $groupName }}</h6>
                                <div class="row g-2">
                                    @foreach($groupPermissions as $permission)
                                    <div class="col-6 col-md-3 col-lg-2">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                            <label class="form-check-label mr-3" for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">إضافة الدور</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">رجوع</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAllPermissions');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                checkAll.checked = Array.from(checkboxes).every(c => c.checked);
            });
        });
    });
</script>
@endsection