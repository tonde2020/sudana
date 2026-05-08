<?php

namespace App\Http\Controllers;

use App\Models\VirtualTour;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VirtualTourController extends Controller
{
    public function show(string $slug): View
    {
        $tour = VirtualTour::query()
            ->with([
                'state',
                'locality',
                'entry.category',
            ])
            ->where('slug', $slug)
            ->where('status', VirtualTour::STATUS_PUBLISHED)
            ->first();

        if ($tour === null) {
            throw new NotFoundHttpException;
        }

        return view('virtual-tours.show', [
            'tour' => $tour,
        ]);
    }
}
