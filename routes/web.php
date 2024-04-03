<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['verify.shopify', 'verify.scopes'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
