<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $amount
 * @property string $slug
 * @property string $voucher_no
 * @property int $reference_id
 * @property string $reference_type
 * @property Carbon|null $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property 'opening'|'sale'|'due'|'discount'|'vat'|'payment' $type
 */
final class Journal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'date',
        'type',
        'slug',
        'amount',
        'voucher_no',
        'reference_type',
        'reference_id',
    ];

    /**
     *  Get the parent reference model (sale, payment, etc.).
     *
     * @return MorphTo<Model, Journal>
     */
    public function reference(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');
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
