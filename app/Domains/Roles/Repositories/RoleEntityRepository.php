<?php

namespace App\Domains\Roles\Repositories;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleEntityRepository
{
    public function all()
    {
        return Role::all();
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, array $data)
    {
        $model = Role::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return Role::destroy($id);
    }
}