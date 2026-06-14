<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasUuid, SoftDeletes;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'rent' => 'decimal:2',
        'fine' => 'decimal:2',
        'active' => 'boolean',
    ];

    protected $with = ["category"];

    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? Storage::temporaryUrl($value, now()->addDay()) : null
        );
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function quantity(): HasOne
    {
        return $this->hasOne(Quantity::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false,
            fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['category'] ?? false,
            fn($query, $category) =>
            $query->whereHas('category',
                fn($query) =>
                $query->where('name', $category)
            )
        );
    }
}
