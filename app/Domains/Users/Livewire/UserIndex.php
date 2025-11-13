<?php

namespace App\Domains\Users\Livewire;

use Livewire\Component;
use App\Domains\Auth\Models\Admin as UserEntity;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $selected = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deleteItem'     => 'deleteItem',
        'deleteSelected' => 'deleteSelected',
        'refreshComponent' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteItem($id)
    {
        if ($id) {
            if (auth('admin')->id() == $id) {
                $this->dispatch('swal:error', [
                    'title' => 'خطأ!',
                    'text'  => 'لا يمكنك حذف نفسك.',
                ]);
                return;
            }

            UserEntity::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title' => 'تم الحذف!',
                'text'  => 'تم حذف البيانات بنجاح.'
            ]);

            $this->dispatch('refreshComponent');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = UserEntity::pluck('id')->toArray();
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
                'text'  => 'يرجى تحديد مستخدمين للحذف أولاً.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'type'  => 'bulk',
            'title' => 'هل أنت متأكد؟',
            'text'  => 'سيتم حذف ' . count($this->selected) . ' مستخدم ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            return;
        }

        UserEntity::whereIn('id', $this->selected)
            ->where('id', '!=', auth('admin')->id())
            ->delete();

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('swal:success', [
            'title' => 'تم الحذف',
            'text' => 'تم حذف العناصر المحددة بنجاح',
        ]);
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $users = UserEntity::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('users::livewire.user-index', compact('users'));
    }
}
