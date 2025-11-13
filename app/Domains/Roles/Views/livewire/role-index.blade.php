<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                @can('delete role')
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @endcan
                @else
                @can('create role')
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة دور جديد
                </a>
                @endcan
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة الأدوار</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} دور</div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-md-nowrap">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" wire:model.live="selectAll">
                            </th>
                            <th>#</th>
                            <th>اسم الدور</th>
                            <th>الصلاحيات</th>
                            <th>تاريخ الإنشاء</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                        <tr class="@if(in_array($role->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $role->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <span class="badge bg-info text-light">{{ $role->permissions->count() }}</span>
                            </td>
                            <td>{{ $role->created_at->format('Y-m-d') }}</td>
                            <td>
                                @can('edit role')
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete role')
                                <button wire:click="confirmDelete({{ $role->id }})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-user-shield fa-2x text-muted mb-2"></i>
                                <br>
                                لا يوجد أدوار
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>