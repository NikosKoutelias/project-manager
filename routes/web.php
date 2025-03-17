<?php

use Illuminate\Support\Facades\Route;

Route::get('/{vue_capture?}', function () {
    return view('bind');
})->where('vue_capture', '[\/\w\.-]*');

require __DIR__.'/auth.php';
