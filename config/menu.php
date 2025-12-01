<?php

return [
    [
        'label'  => 'الرئيسية',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-home fa-lg menu-icon"></i>',
        'url'    => '/admin/dashboard',
        // 'badge'  => 1,
        // 'badge-color'  => 'success',
    ],
    [
        'label'  => 'الكشف',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-stethoscope fa-lg menu-icon"></i>',
        'url'    => '/admin/examinations',
        'can'    => 'view examinations',
    ],
    [
        'label'  => 'التقارير',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-chart-bar me-2"></i>',
        'url'    => '/admin/reports',
        'can'    => 'view reports',
    ],
    [
        'label'  => 'الزيارات',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-calendar-check fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/visits', 'can' => 'view visits'],
            ['label' => 'إضافة جديد', 'url' => '/admin/visits/create', 'can' => 'create visit'],
        ],
    ],
    [
        'label'  => 'الحجوزات',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-calendar-alt fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الحجوزات', 'url' => '/admin/reservations', 'can' => 'view visits'],
            ['label' => 'إضافة حجز جديد', 'url' => '/admin/reservations/create', 'can' => 'create visit'],
        ],
    ],
    [
        'label'  => 'المرضي',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-user-injured fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/patients', 'can' => 'view patients'],
            ['label' => 'إضافة جديد', 'url' => '/admin/patients/create', 'can' => 'create patient'],
        ],
    ],
    [
        'label'  => 'الخدمات الطبية',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-notes-medical fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/services', 'can' => 'view services'],
            ['label' => 'إضافة جديد', 'url' => '/admin/services/create', 'can' => 'create service'],
        ],
    ],
    [
        'label'  => 'الأدوية',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-pills fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/drugs', 'can' => 'view drugs'],
            ['label' => 'إضافة جديد', 'url' => '/admin/drugs/create', 'can' => 'create drug'],
        ],
    ],
    [
        'label'  => 'المستخدمين',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-users fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/users', 'can' => 'view users'],
            ['label' => 'إضافة جديد', 'url' => '/admin/users/create', 'can' => 'create user'],
        ],
    ],
    [
        'label'  => 'الأدوار والصلاحيات',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-user-shield fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الأدوار', 'url' => '/admin/roles', 'can' => 'view roles'],
            ['label' => 'إضافة دور جديد', 'url' => '/admin/roles/create', 'can' => 'create role'],
            ['label' => 'عرض الصلاحيات', 'url' => '/admin/permissions', 'can' => 'view permissions'],
            ['label' => 'إضافة صلاحية جديدة', 'url' => '/admin/permissions/create', 'can' => 'create permission'],
        ],
    ],
    [
        'label'  => 'الإعدادات',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-cog fa-lg menu-icon"></i>',
        'url'    => '/admin/settings',
        'can'    => 'view settings',
    ],
];
