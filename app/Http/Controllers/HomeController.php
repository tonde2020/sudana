<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Entry;
use App\Models\InvestmentOpportunity;
use App\Models\Locality;
use App\Models\Service;
use App\Models\State;
use App\Models\Story;
use App\Models\VirtualTour;
use App\Support\FeatureTableGuard;
use App\Support\SudanMap;
use App\Support\SudanStateCatalog;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->string('q'));

        $states = State::query()
            ->withCount('localities')
            ->withCount('entries')
            ->withCount('services')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner
                        ->where('name_ar', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%")
                        ->orWhere('capital', 'like', "%{$search}%");
                });
            })
            ->orderBy('name_ar')
            ->get();

        if ($states->isEmpty()) {
            $states = collect(SudanStateCatalog::forHomepage());
        }

        $featuredTours = VirtualTour::query()
            ->with(['state'])
            ->where('status', VirtualTour::STATUS_PUBLISHED)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(4)
            ->get()
            ->map(fn (VirtualTour $tour) => [
                'title' => $tour->title,
                'tag' => $tour->locality?->name_ar ?? $tour->state?->name_ar ?? 'السودان',
                'src' => $tour->preview_image_url ?: $tour->state?->hero_image_url ?: asset('images/state-placeholder.svg'),
                'url' => route('virtual-tours.show', $tour->slug),
            ])
            ->all();

        if ($featuredTours === []) {
            $featuredTours = Entry::query()
                ->with(['state'])
                ->whereNotNull('panorama_path')
                ->where('status', Entry::STATUS_PUBLISHED)
                ->latest('published_at')
                ->latest('id')
                ->take(4)
                ->get()
                ->map(fn (Entry $entry) => [
                    'title' => $entry->title,
                    'tag' => $entry->state?->name_ar ?? 'السودان',
                    'src' => data_get($entry->meta, 'image', $entry->state?->hero_image_url ?? asset('images/state-placeholder.svg')),
                    'url' => route('entries.show', $entry->slug),
                ])
                ->all();
        }

        $investmentFeatureAvailable = FeatureTableGuard::hasTables(['investment_opportunities', 'investment_offices']);
        $storiesFeatureAvailable = FeatureTableGuard::hasTables(['stories', 'story_people']);

        return response()
            ->view('welcome', [
            'states' => $states,
            'featuredTours' => $featuredTours,
            'portalStats' => [
                'investment_opportunities' => $investmentFeatureAvailable ? InvestmentOpportunity::query()->published()->count() : 0,
                'stories' => $storiesFeatureAvailable ? Story::query()->published()->count() : 0,
                'investment_feature_available' => $investmentFeatureAvailable,
                'stories_feature_available' => $storiesFeatureAvailable,
            ],
            'stats' => [
                'states' => State::query()->count() ?: count(SudanStateCatalog::forHomepage()),
                'localities' => Locality::query()->count(),
                'entries' => Entry::query()->count(),
                'services' => Service::query()->count(),
                'contributions' => Contribution::query()->count(),
            ],
        ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
}
