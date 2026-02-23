<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('manage_branches');
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'location'  => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'whatsapp'  => ['nullable', 'string', 'max:20'],
            'map_url'   => ['nullable', 'url', 'max:500'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'اسم الفرع مطلوب',
            'location.required' => 'موقع الفرع مطلوب',
            'name.max'          => 'اسم الفرع يجب ألا يتجاوز 255 حرفاً',
            'location.max'      => 'الموقع يجب ألا يتجاوز 255 حرفاً',
        ];
    }
}
