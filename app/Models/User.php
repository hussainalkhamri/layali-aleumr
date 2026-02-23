<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'role_id',
        'branch_id',
        'full_name',
        'username',
        'phone',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active'            => 'boolean',
        'password'             => 'hashed',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BookingInvoice::class, 'created_by');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'received_by');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'logged_by');
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function hasPermission(string $permission): bool
    {
        if (! $this->role) return false;
        if ($this->role->isSuperAdmin()) return true;
        return $this->role->hasPermission($permission);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role?->isSuperAdmin() ?? false;
    }

}
