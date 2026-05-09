<?php

namespace Tests\Feature;

use App\Filament\Resources\InvestmentOpportunityResource;
use App\Filament\Resources\StoryResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('mobile-header', false)
            ->assertSee(route('investment.index'), false)
            ->assertDontSee('<details', false)
            ->assertDontSee('<summary', false);
    }

    public function test_the_investment_portal_is_available(): void
    {
        $response = $this->get('/investment');

        $response
            ->assertOk()
            ->assertSee('mobile-header', false);
    }

    public function test_the_stories_portal_is_available(): void
    {
        $response = $this->get('/stories');

        $response->assertOk();
    }

    public function test_language_switch_route_redirects_back(): void
    {
        $response = $this->from('/')->get('/language/en');

        $response->assertRedirect('/');
        $this->assertSame('en', session('locale'));
    }

    public function test_homepage_uses_ltr_direction_for_english_locale(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get('/');

        $response
            ->assertOk()
            ->assertSee('dir="ltr"', false)
            ->assertSee('lang="en"', false);
    }

    public function test_new_portals_fail_gracefully_when_feature_tables_are_missing(): void
    {
        Schema::dropIfExists('stories');
        Schema::dropIfExists('story_people');
        Schema::dropIfExists('investment_opportunities');
        Schema::dropIfExists('investment_offices');

        $this->get('/stories')
            ->assertOk()
            ->assertSee('بوابة الحكايات', false);

        $this->get('/investment')
            ->assertOk()
            ->assertSee('بوابة الاستثمار', false);

        $this->assertFalse(StoryResource::canAccess());
        $this->assertFalse(InvestmentOpportunityResource::canAccess());
    }
}
