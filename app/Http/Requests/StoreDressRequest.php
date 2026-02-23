<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // auth middleware handles authentication
    }

    public function rules(): array
    {
        return [
            'name'                => ['required', 'string', 'max:255'],
            'dress_type'          => ['required', 'string', 'max:100'],
            'current_branch_id'   => ['nullable', 'exists:branches,id'],
            'current_status'      => ['in:available,booked,cleaning,transit'],
            'chest_size'          => ['nullable', 'string', 'max:20'],
            'waist_size'          => ['nullable', 'string', 'max:20'],
            'color'               => ['nullable', 'string', 'max:100'],
            'max_usage_limit'     => ['integer', 'min:1'],
            'current_usage_count' => ['integer', 'min:0'],
            'rental_price'        => ['nullable', 'numeric', 'min:0'],
            'sale_price'          => ['nullable', 'numeric', 'min:0'],
            'image_url'           => ['nullable', 'string', 'max:500'],
            'image'               => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'show_in_catalog'     => ['boolean'],
            'is_active'           => ['boolean'],
            'cleaning_days'       => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'اسم الفستان مطلوب',
            'dress_type.required' => 'نوع الفستان مطلوب',
            'image.image'         => 'الملف المرفوع يجب أن يكون صورة',
            'image.mimes'         => 'صيغة الصورة يجب أن تكون jpeg, png, jpg أو webp',
            'image.max'           => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
            'rental_price.numeric'=> 'سعر الإيجار يجب أن يكون رقماً',
            'sale_price.numeric'  => 'سعر البيع يجب أن يكون رقماً',
        ];
    }
}
