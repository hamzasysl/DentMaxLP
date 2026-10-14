<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Invisalign\Index as InvisalignIndex;
use App\Livewire\Ui\ThankYou;
/*
|--------------------------------------------------------------------------
| Lang olmayan istekleri yut (SEO / güvenlik)
|--------------------------------------------------------------------------
*/
Route::get('/{any}', function () {
    return response('', 204);
})->where('any', '^(?![a-zA-Z]{2}(/|$)).*');


Route::group(['prefix' => '{lang}'], function () {
    // /tr -> /tr/{default_lp}
    Route::get('/', fn (string $lang) => redirect("/{$lang}/" . config('brand.default_lp')));

    /*
    |--------------------------------------------------------------------------
    | Invisalign LP
    |--------------------------------------------------------------------------
    */
    Route::prefix('invisalign')->group(function () {
        Route::get('/', InvisalignIndex::class)->name('invisalign.index');
    });

    /*
    |--------------------------------------------------------------------------
    | 🔥 TEK THANK YOU (LP BAZLI – DİNAMİK)
    |--------------------------------------------------------------------------
    */
    Route::get('{lp}/thank-you', ThankYou::class)
        ->name('lp.thank-you');

});
