<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cafe_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock_quantity',
        'is_available',
        'badges',
        'discount_price',
        'special_until',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'badges' => 'array',
        'special_until' => 'datetime',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://via.placeholder.com/600x400';
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
