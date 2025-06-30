<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $purchase_price
 * @property string $sell_price
 * @property integer $opening_stock
 * @property integer $current_stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'purchase_price',
        'sell_price',
        'opening_stock',
        'current_stock'
    ];
}
