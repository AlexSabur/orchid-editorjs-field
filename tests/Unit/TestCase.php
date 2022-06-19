<?php

namespace Tests\Unit;

use AlexSabur\OrchidEditorJSField\Support\Providers\EditorJSServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Orchid\Platform\Models\User;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Platform\Providers\PlatformServiceProvider;

class TestCase extends BaseTestCase
{
    protected $user;

    protected function setUp(): void
    {
        $this->beforeApplicationDestroyed(function () {
            Artisan::call('view:clear');
        });

        $this->afterApplicationCreated(function () {
            Artisan::call('view:clear');
        });

        parent::setUp();

        $this->loadLaravelMigrations();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(base_path('vendor/orchid/platform/database/migrations/migrations')),
        ]);

        Factory::guessFactoryNamesUsing(function ($factory) {
            $factoryBasename = class_basename($factory);

            return "Tests\Factories\\$factoryBasename".'Factory';
        });

        $this->user = User::factory()->make();
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('view.paths', [
            __DIR__.'/views',
            resource_path('views'),
        ]);

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function makeACleanSlate()
    {
        Artisan::call('view:clear');
    }

    protected function getPackageProviders($app)
    {
        return [
            FoundationServiceProvider::class,
            PlatformServiceProvider::class,
            EditorJSServiceProvider::class,
        ];
    }
}
