<?php

namespace App\Domains\Users\Livewire;

use Livewire\Component;
use App\Domains\Users\Models\UserEntity;

class UserEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;

    protected $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,{{id}}',
        'password' => 'nullable|min:6'
    ];

    public function mount($id)
    {
        $user = UserEntity::findOrFail($id);

        $this->userId   = $user->id;
        $this->name     = $user->name;
        $this->email    = $user->email;
    }

    public function update()
    {
        $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6',
        ]);

        $user = UserEntity::findOrFail($this->userId);

        $user->name  = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $this->dispatch('swal:success', [
            'title' => 'تم التحديث!',
            'text'  => 'تم تعديل بيانات المستخدم بنجاح.'
        ]);

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('users::livewire.user-edit');
    }
}
