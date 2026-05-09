<?php

namespace App\Http\Controllers;

use App\Models\InvestmentOpportunity;
use App\Support\FeatureTableGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class InvestmentOpportunityController extends Controller
{
    public function index(): View
    {
        $featureAvailable = FeatureTableGuard::hasTables(['investment_opportunities', 'investment_offices']);

        $opportunities = $featureAvailable
            ? InvestmentOpportunity::query()
                ->with(['state', 'locality', 'office', 'category'])
                ->published()
                ->orderByDesc('is_featured')
                ->latest('published_at')
                ->latest('id')
                ->get()
            : new Collection();

        return view('investment.index', [
            'opportunities' => $opportunities,
            'featureAvailable' => $featureAvailable,
        ]);
    }

    public function show(string $slug): View
    {
        abort_unless(FeatureTableGuard::hasTables(['investment_opportunities', 'investment_offices']), 404);

        $opportunity = InvestmentOpportunity::query()
            ->with(['state', 'locality', 'office', 'category'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedOpportunities = InvestmentOpportunity::query()
            ->published()
            ->where('id', '!=', $opportunity->id)
            ->where('state_id', $opportunity->state_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('investment.show', [
            'opportunity' => $opportunity,
            'relatedOpportunities' => $relatedOpportunities,
        ]);
    }
}
