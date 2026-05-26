<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaidItem extends Model
{
    protected $fillable = ['payment_id', 'book_id'];
    protected $with=['book'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
