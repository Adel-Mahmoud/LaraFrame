<?php

namespace App\Domains\Roles\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleEdit extends Component
{
    public $roleId;
    public $name;
    public $permissions = [];
    public $allPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,name',
    ];

    public function mount($id)
    {
        $role = Role::findOrFail($id);

        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->permissions = $role->permissions()->pluck('name')->toArray();
        $this->allPermissions = Permission::all();
    }

    public function update()
    {
        $this->validate();

        $role = Role::findOrFail($this->roleId);
        $role->name = $this->name;
        $role->save();

        if (!empty($this->permissions)) {
            $role->syncPermissions($this->permissions);
        } else {
            $role->syncPermissions([]);
        }

        $this->dispatch('swal:success', [
            'title' => 'تم التحديث!',
            'text'  => 'تم تعديل بيانات الدور بنجاح.'
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('roles::livewire.role-edit', [
            'allPermissions' => $this->allPermissions,
        ]);
    }
}
