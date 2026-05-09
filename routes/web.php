<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestmentOpportunityController;
use App\Http\Controllers\LocalityController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\VirtualTourController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(array_key_exists($locale, config('localization.supported_locales', [])), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::redirect('/contributor/login', '/admin/login')->name('contributor.login');
Route::get('/join', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/join', [VolunteerController::class, 'store'])->name('volunteer.store');

Route::get('/states/{slug}', [StateController::class, 'show'])->name('states.show');
Route::get('/states/{stateSlug}/localities/{localitySlug}', [LocalityController::class, 'show'])->name('localities.show');
Route::get('/entries/{slug}', [EntryController::class, 'show'])->name('entries.show');
Route::get('/virtual-tours/{slug}', [VirtualTourController::class, 'show'])->name('virtual-tours.show');
Route::get('/investment', [InvestmentOpportunityController::class, 'index'])->name('investment.index');
Route::get('/investment/opportunities/{slug}', [InvestmentOpportunityController::class, 'show'])->name('investment.show');
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/{slug}', [StoryController::class, 'show'])->name('stories.show');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
