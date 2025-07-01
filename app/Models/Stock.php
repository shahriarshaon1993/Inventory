<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property 'opening'|'purchase'|'sale'|'reversal' $type
 * @property int $quantity
 * @property string $price
 * @property Carbon|null $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Stock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id', 
        'type',
        'quantity',
        'price',
        'date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    /**
     * Stock belongs to product
     * 
     * @return BelongsTo<Product, Stock>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
