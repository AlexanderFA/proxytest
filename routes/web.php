<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxiesController;

Route::match(['GET', 'POST'], '/', [ProxiesController::class, 'index']);

Route::get('/welcome', function () { return view('welcome'); });
