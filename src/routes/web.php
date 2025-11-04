<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/set-locale/{locale}', function (string $locale) {
    session(['locale' => $locale]);
    return back();
})->name('admin.set-locale')->middleware(['web']);
