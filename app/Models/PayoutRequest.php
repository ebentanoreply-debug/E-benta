<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayoutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'seller_wallet_id',
        'amount',
        'status',
        'destination_type',
        'destination_label',
        'admin_notes',
        'requested_at',
        'approved_at',
        'paid_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'paid_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(SellerWallet::class, 'seller_wallet_id');
    }
}
