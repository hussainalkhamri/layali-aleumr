<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receipt_no'         => ['nullable', 'string', 'max:50', 'unique:receipts,receipt_no'],
            'booking_invoice_id' => ['required', 'exists:booking_invoices,id'],
            'amount'             => ['required', 'numeric', 'min:0.01'],
            'receipt_nature'     => ['required', 'in:deposit,final_payment,extra'],
            'payment_method'     => ['required', 'in:cash,transfer'],
        ];
    }

    public function messages(): array
    {
        return [
            'booking_invoice_id.required' => 'الفاتورة مطلوبة',
            'booking_invoice_id.exists'   => 'الفاتورة غير موجودة',
            'amount.required'             => 'المبلغ مطلوب',
            'amount.min'                  => 'المبلغ يجب أن يكون أكبر من صفر',
            'receipt_nature.required'     => 'نوع الإيصال مطلوب',
            'payment_method.required'     => 'طريقة الدفع مطلوبة',
        ];
    }
}
