<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class RentHistory extends Model
{
    protected $table = "rent_history";
    protected $guarded = ['id', 'created_at','updated_at'];
    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'rent_paid' => 'decimal:2',
        'fine_paid' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getDurationAttribute()
    {
        return Carbon::parse($this->issue_date)->diffInDays($this->return_date) + 1;
    }

    public function getOverdueDaysAttribute()
    {
        $dueDate = Carbon::parse($this->due_date)->startOfDay();
        $today = Carbon::now()->startOfDay();

        return $today->isAfter($dueDate)
            ? $today->diffInDays($dueDate, true)
            : 0;
    }
}
