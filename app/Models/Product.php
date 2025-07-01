<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $purchase_price
 * @property string $sell_price
 * @property int $opening_stock
 * @property int $current_stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'purchase_price',
        'sell_price',
        'opening_stock',
        'current_stock'
    ];
}
