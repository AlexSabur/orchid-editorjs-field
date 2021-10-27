<?php

namespace AlexSabur\OrchidEditorJSField\Support\Providers;

use AlexSabur\OrchidEditorJSField\EditorJS;
use AlexSabur\OrchidEditorJSField\Support\Commands\ToolCommand;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Support\Facades\Dashboard;

class EditorJSServiceProvider extends ServiceProvider
{
    public function register()
    {
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

            $this->loadRoutesFrom(__DIR__ . '/../../../routes/systems.php');
        });
    }
}
