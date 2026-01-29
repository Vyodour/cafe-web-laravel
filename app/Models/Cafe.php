<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cafe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'email',
        'image',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
