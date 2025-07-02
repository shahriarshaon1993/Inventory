<?php

namespace App\Http\Controllers;

use App\Actions\Journals\GetGournal;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class JournalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, GetGournal $action)
    {
        $journals = $action->handle($request);

        return view('journals.index', [
            'groups' => $journals
        ]);
    }

    public function show(int $id, string $slug)
    {
        $journals = Journal::query()
            ->where('slug', $slug)
            ->where('reference_id', $id)
            ->get();

        return view('journals.show', [
            'journals' => $journals
        ]);
    }
}
