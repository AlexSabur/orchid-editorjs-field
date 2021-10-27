<?php

namespace AlexSabur\OrchidEditorJSField\Support\Providers;

use AlexSabur\OrchidEditorJSField\Support\Commands\ToolCommand;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Support\Facades\Dashboard;

class PlatformServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ .  '/../../../config/orchid-editorjs-field.php',
            'orchid-editorjs-field'
        );

        $this->booted(function () {
            Dashboard::addPublicDirectory(
                'editorjs',
                __DIR__ .  '/../../../public'
            );

            View::composer('platform::app', function () {
                Dashboard::registerResource('scripts', orchid_mix('/js/editorjs.js', 'editorjs'));
            });

            if ($this->app->runningInConsole()) {
                $this->commands([
                    ToolCommand::class,
                ]);
            }

            $this->loadViewsFrom(
                __DIR__ . '/../../../resources/views',
                'orchid-editorjs-field'
            );

            $this->publishes(
                [
                    __DIR__ .  '/../../../config/orchid-editorjs-field.php' => config_path('orchid-editorjs-field.php'),
                ],
                'config'
            );
        });
    }
}
