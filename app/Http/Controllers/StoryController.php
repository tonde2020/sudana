<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Support\FeatureTableGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class StoryController extends Controller
{
    public function index(): View
    {
        $featureAvailable = FeatureTableGuard::hasTables(['stories', 'story_people']);

        $stories = $featureAvailable
            ? Story::query()
                ->with(['state', 'locality', 'person'])
                ->published()
                ->orderByDesc('is_featured')
                ->latest('published_at')
                ->latest('id')
                ->get()
            : new Collection();

        return view('stories.index', [
            'stories' => $stories,
            'featureAvailable' => $featureAvailable,
        ]);
    }

    public function show(string $slug): View
    {
        abort_unless(FeatureTableGuard::hasTables(['stories', 'story_people']), 404);

        $story = Story::query()
            ->with(['state', 'locality', 'person'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedStories = Story::query()
            ->published()
            ->where('id', '!=', $story->id)
            ->where('state_id', $story->state_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('stories.show', [
            'story' => $story,
            'relatedStories' => $relatedStories,
        ]);
    }
}
