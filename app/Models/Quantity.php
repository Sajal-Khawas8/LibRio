<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quantity extends Model
{
    protected $fillable = ['book_id', 'copies', 'available'];
    
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
