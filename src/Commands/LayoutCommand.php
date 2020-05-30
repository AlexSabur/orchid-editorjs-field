<?php

namespace AlexSabur\OrchidEditorJSField\Commands;

use AlexSabur\OrchidEditorJSField\Providers\ServiceProvider;
use Illuminate\Console\GeneratorCommand;

class LayoutCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:editorjs:layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new editorjs layout class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'EditorJS';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return ServiceProvider::PACKAGE_PATH . 'resources/stubs/editorjs.layout.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Layouts';
    }
}
