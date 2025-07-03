<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Journals\GetGournal;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class JournalController
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, GetGournal $action): View
    {
        $journals = $action->handle($request);

        return view('journals.index', [
            'groups' => $journals,
        ]);
    }

    public function show(int $id, string $slug): View
    {
        $journals = Journal::query()
            ->where('slug', $slug)
            ->where('reference_id', $id)
            ->get();

        return view('journals.show', [
            'journals' => $journals,
        ]);
    }
}
