<?php

namespace Database\Seeders;

use App\Models\BookingInvoice;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReceiptSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = BookingInvoice::all();
        $users = User::all();

        if ($invoices->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($invoices as $index => $invoice) {
            // Create a deposit receipt
            Receipt::create([
                'id' => Str::uuid(),
                'receipt_no' => 'REC-' . (3025001 + ($index * 2)),
                'booking_invoice_id' => $invoice->id,
                'received_by' => $users->random()->id,
                'amount' => $invoice->paid_advance,
                'receipt_nature' => 'deposit',
                'payment_method' => 'cash',
            ]);

            // Optionally create a final payment receipt if invoice is completed
            if ($invoice->status === 'completed') {
                Receipt::create([
                    'id' => Str::uuid(),
                    'receipt_no' => 'REC-' . (3025001 + ($index * 2) + 1),
                    'booking_invoice_id' => $invoice->id,
                    'received_by' => $users->random()->id,
                    'amount' => $invoice->remaining_amount,
                    'receipt_nature' => 'final_payment',
                    'payment_method' => 'transfer',
                ]);
            }
        }
    }
}
