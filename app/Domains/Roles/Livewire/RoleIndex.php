<?php

namespace App\Domains\Roles\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selected = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deleteItem',
        'deleteSelected',
        'refreshComponent' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteItem($id)
    {
        if ($id) {
            Role::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title' => 'تم الحذف!',
                'text'  => 'تم حذف الدور بنجاح.'
            ]);

            $this->dispatch('refreshComponent');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Role::pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id'    => $id,
            'title' => 'هل أنت متأكد؟',
            'text'  => 'لن يمكنك التراجع بعد الحذف!',
            'type'  => 'single'
        ]);
    }

    public function confirmDeleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('swal:error', [
                'title' => 'لم يتم التحديد',
                'text'  => 'يرجى تحديد أدوار للحذف أولاً.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'type'  => 'bulk',
            'title' => 'هل أنت متأكد؟',
            'text'  => 'سيتم حذف ' . count($this->selected) . ' دور ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;

        Role::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('swal:success', [
            'title' => 'تم الحذف!',
            'text'  => 'تم حذف الأدوار المحددة بنجاح.',
        ]);

        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $roles = Role::with('permissions') 
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('roles::livewire.role-index', compact('roles'));
    }
}
