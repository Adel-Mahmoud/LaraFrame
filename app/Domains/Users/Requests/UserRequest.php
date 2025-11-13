<?php

namespace App\Domains\Users\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($this->route('user')),
            ],
            'password' => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:roles,name',
        ];
    }
}
