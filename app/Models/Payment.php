<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $sale_id
 * @property string $amount
 * @property 'cash'|'card'|'mobile'|'bank' $method
 * @property Carbon|null $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sale_id',
        'amount',
        'method',
        'date',
    ];

    /**
     * Payment belongs to sale
     *
     * @return BelongsTo<Sale, Payment>
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
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
}
