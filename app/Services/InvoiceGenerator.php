<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceGenerator
{
    public static function generate(string $table, string $column, string $prefix = 'INV'): string
    {
        $today = Carbon::now()->format('dmY');
        $prefixLength = strlen($prefix);
        $serialLength = 16 - $prefixLength - 8;

        if ($serialLength < 1) {
            throw new \Exception('Prefix is too long to maintain 16-digit invoice number.');
        }

        $lastInvoice = DB::table($table)
            ->where($column, 'like', "{$prefix}{$today}%")
            ->orderByDesc($column)
            ->value($column);

        if ($lastInvoice) {
            $lastSerial = (int) substr($lastInvoice, -1 * $serialLength);
            $newSerial = str_pad((string) ($lastSerial + 1), $serialLength, '0', STR_PAD_LEFT);
        } else {
            $newSerial = str_pad('1', $serialLength, '0', STR_PAD_LEFT);
        }

        return "{$prefix}{$today}{$newSerial}";
    }
}