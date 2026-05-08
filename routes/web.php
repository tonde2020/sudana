<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalityController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\VirtualTourController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::redirect('/contributor/login', '/admin/login')->name('contributor.login');
Route::get('/join', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/join', [VolunteerController::class, 'store'])->name('volunteer.store');

Route::get('/states/{slug}', [StateController::class, 'show'])->name('states.show');
Route::get('/states/{stateSlug}/localities/{localitySlug}', [LocalityController::class, 'show'])->name('localities.show');
Route::get('/entries/{slug}', [EntryController::class, 'show'])->name('entries.show');
Route::get('/virtual-tours/{slug}', [VirtualTourController::class, 'show'])->name('virtual-tours.show');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
