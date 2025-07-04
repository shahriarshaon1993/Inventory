<?php

declare(strict_types=1);

namespace App\Actions\Journals;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class GetGournal
{
    /**
     * Retrun journal group ways.
     *
     * @return LengthAwarePaginator<int, Journal>
     */
    public function handle(Request $request): LengthAwarePaginator
    {
        // Pagination settings
        $page = $request->get('page', 1);
        $perPage = 15;

        $groups = Journal::query()
            ->select(
                'journals.slug',
                'journals.reference_id',
                'journals.voucher_no',
                'sales.invoice_no',
                DB::raw('COUNT(*) as total'),
                DB::raw('MAX(journals.date) as date'),
                DB::raw('MAX(journals.created_at) as created_at'),
            )
            ->leftJoin('sales', function ($join) {
                $join->on('sales.id', '=', 'journals.reference_id')
                    ->where('journals.slug', '=', 'sale');
            })
            ->groupBy('journals.slug', 'journals.voucher_no', 'journals.reference_id', 'sales.invoice_no')
            ->orderByDesc(DB::raw('MAX(journals.created_at)'))
            ->get();

        return new LengthAwarePaginator(
            $groups->slice(($page - 1) * $perPage, $perPage)->values(),
            $groups->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}
