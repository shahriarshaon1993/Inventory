<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $discount
 * @property string $vat
 * @property string $subtotal
 * @property string $total_amount
 * @property string $paid_amount
 * @property string $due_amount
 * @property Carbon|null $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'vat',
        'date',
        'discount',
        'subtotal',
        'total_amount',
        'paid_amount',
        'due_amount',
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
     * Relation with journals
     * 
     * @return MorphMany<Journal, Payment>
     */
    public function journals(): MorphMany
    {
        return $this->morphMany(Journal::class, 'reference');
    }
}
