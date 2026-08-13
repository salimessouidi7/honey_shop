<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'name',
        'honey_type',
        'description',
        'price',
        'discount_type',
        'discount_value',
        'stock',
        'image_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_value' => 'decimal:2',
    ];

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }

    // Convenience accessor so we always have a placeholder image, same as the old
    // `$product['image_url'] ?: 'https://via.placeholder.com/300x200'` pattern.
    public function getDisplayImageAttribute(): string
    {
        return $this->image_url ?: 'https://via.placeholder.com/300x200';
    }

    // --- Product-level discount (set by admin, applies to everyone: guests, customers, all roles) ---

    public function getHasDiscountAttribute(): bool
    {
        return !empty($this->discount_type) && $this->discount_value > 0;
    }

    // The actual price everyone pays - use this everywhere money is calculated (cart, checkout).
    public function getFinalPriceAttribute(): float
    {
        if (!$this->has_discount) {
            return (float) $this->price;
        }

        $discount = $this->discount_type === 'percent'
            ? $this->price * ($this->discount_value / 100)
            : (float) $this->discount_value;

        return max(0, round((float) $this->price - $discount, 2));
    }

    public function getSavingsAmountAttribute(): float
    {
        return round((float) $this->price - $this->final_price, 2);
    }

    // e.g. "20% OFF" or "$3 OFF" - for badges in the UI
    public function getDiscountLabelAttribute(): ?string
    {
        if (!$this->has_discount) {
            return null;
        }

        if ($this->discount_type === 'percent') {
            $value = rtrim(rtrim(number_format((float) $this->discount_value, 2), '0'), '.');
            return $value . '% OFF';
        }

        return '$' . number_format($this->discount_value, 2) . ' OFF';
    }

    // --- Comments / feedback (gated behind the 'comments' feature toggle) ---

    public function comments(): HasMany
    {
        return $this->hasMany(ProductComment::class)->latest();
    }

    public function getAverageRatingAttribute(): ?float
    {
        $average = $this->comments()->whereNotNull('rating')->avg('rating');
        return $average ? round($average, 1) : null;
    }
}
