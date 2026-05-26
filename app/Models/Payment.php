<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $with = ['user', 'paidItem'];
    protected $casts = [
        'amount' => 'decimal:2',
        'payload' => 'array',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paidItem(): HasMany
    {
        return $this->hasMany(PaidItem::class);
    }

    public function scopeFilter($query, $search)
    {
        $query->when($search ?? false,
            fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('transaction_id', 'like', "%$search%")
                    ->orWhereHas('user',
                        fn($query) =>
                        $query->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%")
                    )
            )
        );
    }
}
