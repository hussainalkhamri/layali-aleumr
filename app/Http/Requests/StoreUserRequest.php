<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('manage_users');
    }

    public function rules(): array
    {
        return [
            'full_name'            => ['required', 'string', 'max:255'],
            'username'             => ['required', 'string', 'max:50', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'phone'                => ['nullable', 'string', 'max:20'],
            'password'             => ['required', Password::min(6)],
            'role_id'              => ['nullable', 'exists:roles,id'],
            'branch_id'            => ['nullable', 'exists:branches,id'],
            'is_active'            => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'full_name.required'            => 'الاسم الكامل مطلوب',
            'full_name.max'                 => 'الاسم الكامل يجب ألا يتجاوز 255 حرفاً',
            'username.required'             => 'اسم المستخدم مطلوب',
            'username.unique'               => 'اسم المستخدم مستخدم بالفعل',
            'username.regex'                => 'اسم المستخدم يجب أن يحتوي على أحرف وأرقام إنجليزية فقط بدون مسافات',
            'username.max'                  => 'اسم المستخدم يجب ألا يتجاوز 50 حرفاً',
            'password.required'             => 'كلمة المرور مطلوبة',
            'password.min'                  => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'role_id.exists'                => 'الدور المحدد غير موجود',
            'branch_id.exists'              => 'الفرع المحدد غير موجود',
        ];
    }
}
