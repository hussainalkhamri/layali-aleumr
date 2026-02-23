<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dress extends Model
{
    use HasUuids;
    protected $fillable = [
        'current_branch_id',
        'name',
        'dress_type',
        'current_status',
        'chest_size',
        'waist_size',
        'color',
        'max_usage_limit',
        'current_usage_count',
        'rental_price',
        'sale_price',
        'image_url',
        'show_in_catalog',
        'is_active',
        'cleaning_days',
    ];

    protected $casts = [
        'show_in_catalog'     => 'boolean',
        'is_active'           => 'boolean',
        'rental_price'        => 'decimal:2',
        'sale_price'          => 'decimal:2',
        'max_usage_limit'     => 'integer',
        'current_usage_count' => 'integer',
        'cleaning_days'       => 'integer',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'current_branch_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BookingInvoice::class);
    }

    public function transferRequests(): HasMany
    {
        return $this->hasMany(TransferRequest::class);
    }

    public function isAvailableOn(string $date): bool
    {
        return ! $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where('output_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->where('return_date', '>=', $date)
                  ->orWhereNull('return_date');
            })
            ->exists();
    }
}
