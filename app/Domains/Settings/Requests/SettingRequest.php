<?php

namespace App\Domains\Settings\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'project_name'      => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'phone'             => 'nullable|string|max:20',
            'address'           => 'nullable|string|max:255',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg,svg|max:3000',
            'brand_image'       => 'nullable|image|mimes:png,jpg,jpeg,svg|max:3000',
        ];
    }
}
