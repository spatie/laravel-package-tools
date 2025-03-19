<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('my-route', fn () => 'my response');

Route::get('execute-command', function () {
    Artisan::call('package-tools:test-command');

    return Artisan::output();
});
