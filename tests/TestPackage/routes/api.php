<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {

    Route::get('api-route', fn () => ['api content']);

});

