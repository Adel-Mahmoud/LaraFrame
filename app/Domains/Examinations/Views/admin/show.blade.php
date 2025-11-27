@extends('layouts.master', ['titlePage' => $titlePage ?? 'زيارة سابقة'])
<x-page-header :titlePage="$titlePage ?? 'زيارة سابقة'" />

@section('css')

<link href="{{ URL::asset('assets/css/examination.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="container-fluid p-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fe fe-user-check me-1"></i>
                نوع الخدمة :
                {{ $visit->visit->service->name }}
            </h5>
        </div>

        <div class="card-body">
            <div class="panel panel-primary tabs-style-2">
                <div class="nav-link active" data-toggle="tab">
                    <i class="fe fe-clipboard me-2"></i> تفاصيل الزيارة
                </div>

                <div class="panel-body tabs-menu-body main-content-body-right border">
                    <div class="tab-pane active">
                        <div class="patient-info-card mb-4">
                            <div class="patient-info-header"><i class="fe fe-user fs-5"></i><span>بيانات الحالة</span></div>
                            <div class="patient-info-grid">
                                <div class="patient-info-item"><span class="patient-info-label">الاسم:</span> <span class="patient-info-value">{{ $visit->visit->patient->user->name ?? 'N/A' }}</span></div>
                                <div class="patient-info-item"><span class="patient-info-label">العمر:</span> <span class="patient-info-value">{{ \Carbon\Carbon::parse($visit->visit->patient->birth_date)->age  ?? 'N/A' }} سنة</span></div>
                                <div class="patient-info-item"><span class="patient-info-label">الجنس:</span> <span class="patient-info-value">{{ $visit->visit->patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</span></div>
                                <div class="patient-info-item"><span class="patient-info-label">الحالة الصحية العامة:</span> <span class="patient-info-value">{{ $visit->visit->patient->general_health_status  ?? 'N/A' }}</span></div>
                                <div class="patient-info-item"><span class="patient-info-label">حساسية الأدوية:</span> <span class="patient-info-value">{{ $visit->visit->patient->drug_allergy ?? 'N/A' }}</span></div>
                            </div>
                        </div>

                        <form id="diagnosisForm" action="{{ route('admin.examinations.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="visit_id" value="{{ $visit->id }}">
                            <div class="form-section">
                                <h6 class="form-section-title"><i class="fe fe-activity me-2"></i> التشخيص الطبي</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">الأعراض:</span> <span class="patient-info-value">{{ $visit->symptoms }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="patient-info-label">التشخيص:</span> <span class="patient-info-value">{{ $visit->diagnosis }}</span>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="form-section">
                        <h6 class="form-section-title"><i class="fe fe-package me-2"></i> الروشتة الطبية</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>اسم الدواء</th>
                                        <th>الجرعة</th>
                                        <th>المدة</th>
                                        <th>الشكل</th>
                                        <th>تعليمات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($visit->drugs as $drug)
                                    <tr>
                                        <td>{{ $drug->drug_name }}</td>
                                        <td>{{ $drug->dose }}</td>
                                        <td>{{ $drug->duration }}</td>
                                        <td>{{ $drug->form }}</td>
                                        <td>{{ $drug->instructions }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">لا توجد أدوية مضافة في الروشتة</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @can('print prescription')
                            <a href="{{ route('admin.examinations.print', $visit->id) }}"
                                class="btn btn-secondary">
                                <i class="fe fe-printer"></i>
                                طباعة الروشتة
                            </a>
                            @endcan
                        </div>
                    </div>

                    <div class="form-section mt-5">
                        <h6 class="form-section-title"><i class="fe fe-sliders me-2"></i> التحاليل والأشعة المطلوبة</h6>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <span class="patient-info-label">نوع الفحص:</span> <span class="patient-info-value">
                                    @if($visit->test_type == 'lab')
                                    تحاليل
                                    @elseif($visit->test_type == 'xray')
                                    أشعة
                                    @else
                                    كلاهما
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-8">
                                <span class="patient-info-label">تفاصيل الفحص:</span> <span class="patient-info-value">{{ $visit->test_details }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-5">
                        <div class="form-section">
                            <h6 class="form-section-title"><i class="fe fe-edit me-2"></i> ملاحظات إضافية</h6>
                            @if($visit->notes && $visit->notes !== '')
                            <span class="patient-info-label">{{ $visit->notes }}</span>
                            @else
                            <span class="patient-info-label">
                                لا يوجد ملاحظات طبية
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="form-section">
                            <h6 class="form-section-title"><i class="fe fe-paperclip me-2"></i> المرفقات</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الملف</th>
                                            <th>نوع الملف</th>
                                            <th>ملاحظات</th>
                                            <th>عرض</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($visit->attachments as $index => $attachment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ basename($attachment->file_path) }}</td>
                                            <td>{{ $attachment->file_type }}</td>
                                            <td>{{ $attachment->notes ?: 'لا يوجد ملاحظات' }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fe fe-eye"></i>                                                
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد مرفقات لهذا الكشف</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection