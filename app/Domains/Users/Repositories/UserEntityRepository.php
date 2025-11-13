<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Auth\Models\Admin;
 
class UserEntityRepository
{
    public function all()
    {
        return Admin::latest()->get();
    }

    public function find($id)
    {
        return Admin::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = Admin::create($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    public function delete($id)
    {
        return Admin::destroy($id);
    }
}
