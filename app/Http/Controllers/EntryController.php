<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntryController extends Controller
{
    public function show(string $slug): View
    {
        $entry = Entry::query()
            ->with(['state', 'locality', 'category', 'author'])
            ->where('slug', $slug)
            ->first();

        if ($entry === null) {
            throw new NotFoundHttpException;
        }

        return view('entries.show', [
            'entry' => $entry,
        ]);
    }
}
