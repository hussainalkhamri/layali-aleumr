<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_no'        => ['nullable', 'string', 'max:50', 'unique:booking_invoices,invoice_no' . ($this->route('booking') ? ',' . $this->route('booking')->id : '')],
            'dress_id'          => ['required', 'exists:dresses,id'],
            'contract_type'     => ['required', 'in:rental,sale'],
            'customer_name'     => ['required', 'string', 'max:255'],
            'customer_phone'    => ['required', 'string', 'max:20'],
            'reserved_for_date' => ['required', 'date'],
            'output_date'       => ['required', 'date'],
            'return_date'       => ['nullable', 'date', 'after_or_equal:output_date'],
            'dress_adjustments' => ['nullable', 'string'],
            'accessories'       => ['nullable', 'string'],
            'total_amount'      => ['required', 'numeric', 'min:0'],
            'paid_advance'      => ['numeric', 'min:0'],
            'remaining_amount'  => ['required', 'numeric', 'min:0'],
            'discount_percent'  => ['integer', 'min:0', 'max:100'],
            'payment_method'    => ['nullable', 'string', 'in:cash,transfer'],
            'notes'             => ['nullable', 'string'],
            'status'            => ['nullable', 'string', 'in:active,delivered,completed,cancelled'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $total = (float) $this->total_amount;
            $advance = (float) $this->paid_advance;
            $remaining = (float) $this->remaining_amount;

            if (abs($total - ($advance + $remaining)) > 0.01) {
                $validator->errors()->add('remaining_amount', 'المجموع (المقدم + المتبقي) يجب أن يساوي المبلغ الإجمالي');
            }
        });
    }

    public function messages(): array
    {
        return [
            'dress_id.required'          => 'الفستان مطلوب',
            'dress_id.exists'            => 'الفستان غير موجود',
            'contract_type.required'     => 'نوع العقد مطلوب',
            'customer_name.required'     => 'اسم العميل مطلوب',
            'customer_phone.required'    => 'رقم الجوال مطلوب',
            'reserved_for_date.required' => 'تاريخ الحجز مطلوب',
            'output_date.required'       => 'تاريخ الاستلام مطلوب',
            'total_amount.required'      => 'المبلغ الإجمالي مطلوب',
            'return_date.after_or_equal' => 'تاريخ الإرجاع يجب أن يكون بعد تاريخ الاستلام',
        ];
    }
}
