<?php

namespace AlexSabur\OrchidEditorJSField\Support\Providers;

use AlexSabur\OrchidEditorJSField\Support\Commands\ToolCommand;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Support\Facades\Dashboard;

class EditorJSServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->booted(function () {
            $this->publishes([
                __DIR__.'/../../../public' => public_path('vendor/orchid-editorjs-field'),
            ], ['orchid-editorjs-field-assets', 'laravel-assets']);

            View::composer('platform::app', function () {
                Dashboard::registerResource('scripts', mix('/js/editorjs.js', 'vendor/orchid-editorjs-field'));
            });

            if ($this->app->runningInConsole()) {
                $this->commands([
                    ToolCommand::class,
                ]);
            }

            $this->loadViewsFrom(
                __DIR__.'/../../../resources/views',
                'orchid-editorjs-field'
            );

            $this->loadRoutesFrom(__DIR__.'/../../../routes/systems.php');
        });
    }
}
