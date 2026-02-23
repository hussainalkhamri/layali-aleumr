<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingInvoice extends Model
{
    use HasUuids;
    protected $fillable = [
        'invoice_no',
        'dress_id',
        'created_by',
        'branch_id',
        'contract_type',
        'customer_name',
        'customer_phone',
        'reserved_for_date',
        'output_date',
        'return_date',
        'dress_adjustments',
        'accessories',
        'total_amount',
        'paid_advance',
        'remaining_amount',
        'discount_percent',
        'status',
        'notes',
    ];

    protected $casts = [
        'reserved_for_date' => 'date',
        'output_date'       => 'date',
        'return_date'       => 'date',
        'total_amount'      => 'decimal:2',
        'paid_advance'      => 'decimal:2',
        'remaining_amount'  => 'decimal:2',
        'discount_percent'  => 'integer',
    ];

    public function dress(): BelongsTo
    {
        return $this->belongsTo(Dress::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
