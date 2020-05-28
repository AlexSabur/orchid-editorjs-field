<?php

namespace AlexSabur\OrchidEditorJSField\Tests;

use AlexSabur\OrchidEditorJSField\Facades\OrchidEditorJSField;
use AlexSabur\OrchidEditorJSField\ServiceProvider;
use Orchestra\Testbench\TestCase;

class OrchidEditorJSFieldTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'orchid-editorjs-field' => OrchidEditorJSField::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
