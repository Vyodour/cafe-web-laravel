<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'reference_number',
        'payment_status',
        'payment_type',
        'snap_token',
        'gross_amount',
        'transaction_time',
        'va_number',
        'expired_at',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
