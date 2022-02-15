<?php

namespace AlexSabur\OrchidEditorJSField\Support\Commands;

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
        return __DIR__.'/../../../resources/stubs/editorjs.tool.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\EditorJS';
    }
}
