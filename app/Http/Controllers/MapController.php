<?php

namespace App\Http\Controllers;

use App\Support\SudanMap;
use Illuminate\Contracts\View\View;

class MapController extends Controller
{
    public function index(): View
    {
        $states = SudanMap::databaseStates();

        return view('map', [
            'states' => $states,
            'mapStates' => SudanMap::build($states),
        ]);
    }
}
