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
