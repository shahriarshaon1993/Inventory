<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $amount
 * @property int $reference_id
 * @property string $reference_type
 * @property 'sale'|'discount'|'vat'|'payment' $type
 * @property Carbon|null $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Journal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'date',
        'type',
        'amount',
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
}
