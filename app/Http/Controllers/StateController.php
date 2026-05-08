<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\VirtualTour;
use App\Support\SudanStateCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StateController extends Controller
{
    public function show(string $slug): View
    {
        $stateModel = State::query()
            ->with([
                'localities',
                'services.locality',
                'entries.category',
                'virtualTours.entry',
                'virtualTours.locality',
            ])
            ->withCount('localities')
            ->where('slug', $slug)
            ->first();

        if ($stateModel !== null) {
            return view('states.show', [
                'state' => $this->mapDatabaseState($stateModel),
                'mapsSearchBase' => 'https://www.google.com/maps/search/?api=1&query=',
            ]);
        }

        $state = SudanStateCatalog::portalState($slug);

        if ($state === null) {
            throw new NotFoundHttpException;
        }

        return view('states.show', [
            'state' => $state,
            'mapsSearchBase' => 'https://www.google.com/maps/search/?api=1&query=',
        ]);
    }

    private function mapDatabaseState(State $state): object
    {
        $entries = $state->entries;
        $historyEntry = $entries->firstWhere('category.slug', 'history');
        $investmentEntries = $entries->where('category.slug', 'investment')->values();
        $landmarkEntries = $entries->where('category.slug', 'landmarks')->values();
        $peopleEntries = $entries->where('category.slug', 'notable-figures')->values();
        $virtualTourEntries = $landmarkEntries->filter(fn ($entry) => filled($entry->panorama_path))->values();
        $stateVirtualTours = $state->virtualTours
            ->where('status', VirtualTour::STATUS_PUBLISHED)
            ->sortBy([
                ['is_featured', 'desc'],
                ['sort_order', 'asc'],
                ['published_at', 'desc'],
            ])
            ->values();

        $investmentSummary = $investmentEntries->isNotEmpty()
            ? $investmentEntries->map(fn ($entry) => $entry->content)->implode("\n")
            : '<p class="mb-4">لم تتم إضافة فرص الاستثمار لهذه الولاية بعد. يمكن للسفراء والمراجعين تحديث هذا القسم من لوحة التحكم.</p>';

        return (object) [
            'slug' => $state->slug,
            'name_ar' => $state->name_ar,
            'capital' => $state->capital ?: 'غير مضافة',
            'cover_image' => $state->hero_image_url,
            'logo' => $state->logo_url,
            'area' => 'قيد التوثيق',
            'main_activity' => $state->summary ?: 'قيد التوثيق بالتعاون مع سفراء الولاية',
            'localities_count' => $state->localities_count,
            'history_content' => $historyEntry?->content
                ?: ($state->history ?: '<p class="mb-4">لا توجد مادة تاريخية منشورة لهذه الولاية بعد.</p>'),
            'investment_summary' => $investmentSummary,
            'investment_pdf_url' => null,
            'localities' => $state->localities
                ->map(fn ($locality) => [
                    'name' => $locality->name_ar,
                    'name_en' => $locality->name_en,
                    'summary' => $locality->summary ?: 'محلية ضمن الولاية يجري استكمال توثيق بياناتها العامة والخدمية.',
                    'population_estimate' => $locality->population_estimate,
                    'area_km2' => $locality->area_km2,
                    'maps_query' => trim($locality->name_ar . ' ' . $state->name_ar . ' Sudan'),
                    'url' => route('localities.show', ['stateSlug' => $state->slug, 'localitySlug' => $locality->slug]),
                ])
                ->values()
                ->all(),
            'landmarks' => $landmarkEntries
                ->map(fn ($entry) => [
                    'title' => $entry->title,
                    'subtitle' => $entry->excerpt ?: 'معلم موثق ضمن دليل الولاية',
                    'image' => data_get($entry->meta, 'image', $state->hero_image_url),
                    'body' => Str::limit(strip_tags($entry->content), 320),
                    'entry_url' => route('entries.show', $entry->slug),
                    'has_panorama' => filled($entry->panorama_path),
                ])
                ->values()
                ->all(),
            'virtual_tours' => $this->mapVirtualTours($stateVirtualTours, $virtualTourEntries, $state),
            'famous_people' => $peopleEntries
                ->map(fn ($entry) => [
                    'name' => $entry->title,
                    'title' => $entry->excerpt ?: 'شخصية موثقة ضمن دليل الولاية',
                    'image' => data_get($entry->meta, 'image', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80'),
                    'bio' => Str::limit(strip_tags($entry->content), 420),
                    'entry_url' => route('entries.show', $entry->slug),
                ])
                ->values()
                ->all(),
            'services' => $state->services
                ->map(fn ($service) => [
                    'name' => $service->name,
                    'locality_name' => $service->locality?->name_ar ?: $state->name_ar,
                    'phone' => $service->phone_primary ?: $service->phone_secondary ?: 'غير متوفر',
                ])
                ->values()
                ->all(),
            'news_items' => [],
            'events' => [],
        ];
    }

    private function mapVirtualTours(Collection $tours, Collection $fallbackEntries, State $state): array
    {
        if ($tours->isNotEmpty()) {
            return $tours
                ->map(fn (VirtualTour $tour) => [
                    'title' => $tour->title,
                    'subtitle' => $tour->excerpt ?: 'جولة افتراضية موثقة ضمن دليل الولاية',
                    'image' => $tour->preview_image_url ?: $state->hero_image_url,
                    'tour_url' => route('virtual-tours.show', $tour->slug),
                    'locality_name' => $tour->locality?->name_ar,
                ])
                ->values()
                ->all();
        }

        return $fallbackEntries
            ->map(fn ($entry) => [
                'title' => $entry->title,
                'subtitle' => $entry->excerpt ?: 'جولة افتراضية موثقة ضمن دليل الولاية',
                'image' => data_get($entry->meta, 'image', $state->hero_image_url),
                'tour_url' => route('entries.show', $entry->slug),
                'locality_name' => $entry->locality?->name_ar,
            ])
            ->values()
            ->all();
    }
}
