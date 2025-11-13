<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                @can('delete permission')
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @endcan
                @else
                @can('create permission')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة صلاحية جديدة
                </a>
                @endcan
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة الصلاحيات</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} صلاحية</div>
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
                            <th>اسم الصلاحية</th>
                            <th>تاريخ الإنشاء</th>
                            <th width="150">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                        <tr class="@if(in_array($permission->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $permission->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->created_at?->format('Y-m-d') }}</td>
                            <td>
                                @can('edit permission')
                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete permission')
                                <button wire:click="confirmDelete({{ $permission->id }})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-key fa-2x text-muted mb-2"></i>
                                <br>
                                لا يوجد صلاحيات
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>