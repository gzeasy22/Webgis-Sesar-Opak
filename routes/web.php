<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GempaAdminController;


Route::get('/peta', function () {
    return view('peta');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('gempa', GempaAdminController::class)->except(['show']);
});
Route::get('/tentang', function () {
    return view('tentang');
});

