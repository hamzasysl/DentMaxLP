<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Invisalign\Index as InvisalignIndex;
use App\Livewire\Ui\ThankYou;

/*
|--------------------------------------------------------------------------
| Tek dilli, tek sayfalık LP: kök adres doğrudan Invisalign sayfası
|--------------------------------------------------------------------------
*/
Route::get('/', InvisalignIndex::class)->name('home');

Route::get('/tesekkurler', ThankYou::class)->name('thank-you');

/*
|--------------------------------------------------------------------------
| Hasta hikayeleri (içerik: config/stories.php)
|--------------------------------------------------------------------------
*/
Route::get('/hasta-hikayeleri', \App\Livewire\Stories\Index::class)->name('stories.index');
Route::get('/hasta-hikayeleri/{slug}', \App\Livewire\Stories\Show::class)->name('stories.show');

/*
|--------------------------------------------------------------------------
| Eski çok dilli adresler → yeni adresler (kalıcı yönlendirme)
|--------------------------------------------------------------------------
*/
Route::permanentRedirect('/tr', '/');
Route::permanentRedirect('/tr/invisalign', '/');
Route::permanentRedirect('/tr/invisalign/thank-you', '/tesekkurler');
