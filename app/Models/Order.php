<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
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
        return Carbon::parse($this->issue_date)->diffInDays($this->due_date) + 1;
    }

    public function getOverdueDaysAttribute()
    {
        $dueDate = Carbon::parse($this->due_date)->startOfDay();
        $today = Carbon::now()->startOfDay();

        return $today->isAfter($dueDate)
            ? $today->diffInDays($dueDate, true)
            : 0;
    }

    public function getRentAttribute()
    {
        return $this->duration * $this->book->rent;
    }

    public function getFineAttribute()
    {
        return $this->overdueDays * $this->book->fine;
    }
}
