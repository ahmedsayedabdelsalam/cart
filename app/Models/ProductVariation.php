<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasPrice;

    public function getPriceAttribute($value)
    {
        if ($value === null) {
            return $this->product->price;
        }

        return new Money($value);
    }

    public function priceVaries()
    {
        return $this->price->getAmount() !== $this->product->price->getAmount();
    }

    public function stockCount()
    {
        return $this->stock->sum('pivot.stock');
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stock()
    {
        return $this->belongsToMany(self::class, 'product_variation_stock_view')
            ->withPivot([
                'stock',
                'in_stock',
            ]);
    }
}
