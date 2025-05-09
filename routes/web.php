<?php

use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;


Route::get('/{slug}', [LandingPageController::class, 'show'])
->name('landing.show');

Route::post('/contact/submission',[LandingPageController::class,'contactSubmission'])
->name('contactSubmission');
