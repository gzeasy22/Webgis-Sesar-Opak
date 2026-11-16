<?php

use App\Http\Controllers\GempaController;
use Illuminate\Support\Facades\Route;

Route::get('/gempa', [GempaController::class, 'index']);
