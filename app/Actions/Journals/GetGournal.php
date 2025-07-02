<?php

namespace App\Actions\Journals;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetGournal
{
    public function handle(Request $request): LengthAwarePaginator
    {
        // Pagination settings
        $page = $request->get('page', 1);
        $perPage = 15;

        $groups = Journal::query()->select(
                'slug',
                'reference_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('MAX(date) as date'),
                DB::raw('MAX(created_at) as created_at')
            )
            ->groupBy('slug', 'reference_id')
            ->orderByDesc(DB::raw('MAX(created_at)'))
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