<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="بحث بالاسم، البريد، الهاتف، الهوية، الحالة الصحية، الحساسية، أو الملاحظات" wire:model.live.500ms="search">
            </div>
            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected) > 0)
                @can('delete patient')
                <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected) }})
                </button>
                @endcan
                @else
                @can('create patient')
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary mb-2 mb-md-0">
                    <i class="fas fa-plus"></i> إضافة مريض جديد
                </a>
                @endcan
                @endif
            </div>
        </div>
        <div class="card-header pb-0">
            <h4 class="card-title">قائمة المرضى</h4>
            @if(count($selected) > 0)
            <div class="text-muted mt-1">تم تحديد {{ count($selected) }} سجل</div>
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
                            <th>الاسم</th>
                            <th>العنوان</th>
                            <th>الهاتف</th>
                            <th>الجنس</th>
                            <th>العمر</th>
                            <th>تاريخ الإنشاء</th>
                            <th width="170">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                        <tr class="@if(in_array($patient->id, $selected)) table-active @endif">
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selected"
                                    value="{{ $patient->id }}"
                                    class="form-check-input">
                            </td>
                            <td>{{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}</td>
                            <td>{{ optional($patient->user)->name }}</td>
                            <td>{{ $patient->address }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>
                                @if($patient->gender == 'male')
                                <span class="badge bg-primary text-light">ذكر</span>
                                @elseif($patient->gender == 'female')
                                <span class="badge bg-pink text-light">أنثى</span>
                                @else
                                <span class="text-muted text-light">غير محدد</span>
                                @endif
                            </td>
                            <td>
                                @if($patient->birth_date)
                                {{ \Carbon\Carbon::parse($patient->birth_date)->age }} سنة
                                @else
                                <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                            <td>{{ $patient->created_at?->format('Y-m-d') }}</td>
                            <td>
                                @can('create visit')
                                <a href="{{ route('admin.visits.create.with.patient', $patient->id) }}" class="btn btn-sm btn-success"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="إضافة زيارة جديدة">
                                    <i class="fas fa-calendar-plus"></i>
                                </a>
                                @endcan
                                @can('view visits')
                                <a href="{{ route('admin.patient.history', $patient->id) }}" class="btn btn-sm btn-info"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="سجل الزيارات">
                                    <i class="fas fa-clipboard-list"></i>
                                </a>
                                @endcan
                                @can('edit patient')
                                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete patient')
                                <button wire:click="confirmDelete({{ $patient->id }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-user-injured fa-2x text-muted mb-2"></i>
                                <br>
                                لا يوجد مرضى
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>