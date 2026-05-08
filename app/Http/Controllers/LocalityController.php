<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Locality;
use App\Models\VirtualTour;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocalityController extends Controller
{
    public function show(string $stateSlug, string $localitySlug): View
    {
        $locality = Locality::query()
            ->with([
                'state',
                'entries.category',
                'services.category',
                'virtualTours.entry',
            ])
            ->where('slug', $localitySlug)
            ->whereHas('state', fn ($query) => $query->where('slug', $stateSlug))
            ->first();

        if ($locality === null) {
            throw new NotFoundHttpException;
        }

        return view('localities.show', [
            'locality' => $this->mapLocality($locality),
        ]);
    }

    private function mapLocality(Locality $locality): object
    {
        $entries = $locality->entries;

        $historyEntries = $entries->where('category.slug', 'history')->values();
        $landmarkEntries = $entries->where('category.slug', 'landmarks')->values();
        $peopleEntries = $entries->where('category.slug', 'notable-figures')->values();
        $investmentEntries = $entries->where('category.slug', 'investment')->values();

        $virtualTours = $locality->virtualTours
            ->where('status', VirtualTour::STATUS_PUBLISHED)
            ->sortBy([
                ['is_featured', 'desc'],
                ['sort_order', 'asc'],
                ['published_at', 'desc'],
            ])
            ->values();

        if ($virtualTours->isEmpty()) {
            $virtualTours = $landmarkEntries
                ->filter(fn (Entry $entry) => filled($entry->panorama_path))
                ->map(fn (Entry $entry) => (object) [
                    'title' => $entry->title,
                    'excerpt' => $entry->excerpt,
                    'preview_image_url' => data_get($entry->meta, 'image', $locality->state->hero_image_url),
                    'entry_slug' => $entry->slug,
                ])
                ->values();
        }

        return (object) [
            'slug' => $locality->slug,
            'name_ar' => $locality->name_ar,
            'name_en' => $locality->name_en,
            'state_name_ar' => $locality->state->name_ar,
            'state_slug' => $locality->state->slug,
            'summary' => $locality->summary ?: 'جاري استكمال الملخص التعريفي لهذه المحلية.',
            'description' => $locality->description ?: '<p>جاري استكمال المحتوى التفصيلي لهذه المحلية بالتعاون مع السفراء والمساهمين.</p>',
            'population_estimate' => $locality->population_estimate,
            'area_km2' => $locality->area_km2,
            'map_query' => trim($locality->name_ar . ' ' . $locality->state->name_ar . ' Sudan'),
            'history_blocks' => $historyEntries
                ->map(fn (Entry $entry) => [
                    'title' => $entry->title,
                    'content' => $entry->content,
                    'entry_url' => route('entries.show', $entry->slug),
                ])
                ->values()
                ->all(),
            'landmarks' => $landmarkEntries
                ->map(fn (Entry $entry) => [
                    'title' => $entry->title,
                    'subtitle' => $entry->excerpt ?: 'معلم موثق ضمن دليل المحلية',
                    'image' => data_get($entry->meta, 'image', $locality->state->hero_image_url),
                    'body' => Str::limit(strip_tags($entry->content), 260),
                    'entry_url' => route('entries.show', $entry->slug),
                    'has_panorama' => filled($entry->panorama_path),
                ])
                ->values()
                ->all(),
            'people' => $peopleEntries
                ->map(fn (Entry $entry) => [
                    'name' => $entry->title,
                    'title' => $entry->excerpt ?: 'شخصية موثقة ضمن المحلية',
                    'image' => data_get($entry->meta, 'image', $locality->state->hero_image_url),
                    'bio' => Str::limit(strip_tags($entry->content), 320),
                    'entry_url' => route('entries.show', $entry->slug),
                ])
                ->values()
                ->all(),
            'investment_entries' => $investmentEntries
                ->map(fn (Entry $entry) => [
                    'title' => $entry->title,
                    'excerpt' => $entry->excerpt ?: 'فرصة استثمارية أو ملف تنموي مرتبط بالمحلية.',
                    'entry_url' => route('entries.show', $entry->slug),
                ])
                ->values()
                ->all(),
            'services' => $locality->services
                ->map(fn ($service) => [
                    'name' => $service->name,
                    'type' => $service->service_type,
                    'phone' => $service->phone_primary ?: $service->phone_secondary ?: 'غير متوفر',
                    'address' => $service->address,
                    'description' => $service->description,
                ])
                ->values()
                ->all(),
            'virtual_tours' => collect($virtualTours)
                ->map(fn ($tour) => [
                    'title' => $tour->title,
                    'excerpt' => $tour->excerpt ?: 'جولة افتراضية مرتبطة بهذه المحلية.',
                    'image' => $tour->preview_image_url ?? $locality->state->hero_image_url,
                    'tour_url' => filled($tour->slug ?? null)
                        ? route('virtual-tours.show', $tour->slug)
                        : (filled($tour->entry_slug ?? null)
                            ? route('entries.show', $tour->entry_slug)
                            : (filled($tour->entry?->slug ?? null) ? route('entries.show', $tour->entry->slug) : null)),
                ])
                ->values()
                ->all(),
        ];
    }
}
