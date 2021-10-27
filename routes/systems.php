<?php

use AlexSabur\OrchidEditorJSField\Http\Controllers\ImageController;
use AlexSabur\OrchidEditorJSField\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;
use Orchid\Support\Facades\Dashboard;

Route::domain((string) config('platform.domain'))
    ->prefix(Dashboard::prefix('/systems/editorjs'))
    ->as('platform.systems.editorjs.')
    ->middleware(config('platform.middleware.private'))
    ->group(function () {
        Route::post('/image-by-file', [ImageController::class, 'byFile'])
            ->name('image-by-file');

        Route::post('/image-by-url', [ImageController::class, 'byUrl'])
            ->name('image-by-url');

        Route::get('/link', [LinkController::class, 'handle'])
            ->name('link');
    });
