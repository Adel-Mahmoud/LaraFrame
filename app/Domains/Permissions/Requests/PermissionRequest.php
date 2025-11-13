<?php

namespace App\Domains\Permissions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->route('permission'),
            'guard_name' => 'nullable|string|max:255',
        ];
    }
}


