<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'location',
        'phone',
        'whatsapp',
        'map_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function dresses(): HasMany
    {
        return $this->hasMany(Dress::class, 'current_branch_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BookingInvoice::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
