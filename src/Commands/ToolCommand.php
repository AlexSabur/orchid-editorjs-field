<?php

namespace AlexSabur\OrchidEditorJSField\Commands;

use AlexSabur\OrchidEditorJSField\Providers\ServiceProvider;
use Illuminate\Console\GeneratorCommand;

class ToolCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:editorjs:tool';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new editorjs tool class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'EditorJSTool';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return ServiceProvider::PACKAGE_PATH . 'resources/stubs/editorjs.tool.stub';
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
        return $rootNamespace.'\Orchid\Fields\EditorJS';
    }
}
