<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'description' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required'      => 'المبلغ مطلوب',
            'amount.min'           => 'المبلغ يجب أن يكون أكبر من صفر',
            'description.required' => 'الوصف مطلوب',
        ];
    }
}
