<?php

declare(strict_types=1);

namespace Tests\Unit;

use AlexSabur\OrchidEditorJSField\EditorJS;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class FieldTest extends TestCase
{
    public function testHidden(): void
    {
        $field = EditorJS::make('defaultField');

        $this->assertStringContainsString('data-controller="editorjs"', (string) $field);

        $field = EditorJS::make('hiddenField')->hidden();

        $this->assertStringNotContainsString('data-controller="editorjs"', (string) $field);
    }

    public function testInputTypes(): void
    {
        $json = htmlentities('{"time":1234567890,"blocks":[],"version":"2.22.2"}');

        $field = EditorJS::make('fieldNullValue')->value(null);

        $this->assertStringContainsString('value="{}', (string) $field);

        $field = EditorJS::make('fieldStringValue')->value('{"time":1234567890,"blocks":[],"version":"2.22.2"}');

        $this->assertStringContainsString("value=\"{$json}\"", (string) $field);

        $field = EditorJS::make('fieldArrayValue')->value($this->getInputTypeArray());

        $this->assertStringContainsString("value=\"{$json}\"", (string) $field);

        $field = EditorJS::make('fieldJsonableValue')->value($this->getInputTypeJsonableClass());

        $this->assertStringContainsString("value=\"{$json}\"", (string) $field);

        $field = EditorJS::make('fieldArrayableValue')->value($this->getInputTypeArrayableClass());

        $this->assertStringContainsString("value=\"{$json}\"", (string) $field);
    }

    public function getInputTypeArray()
    {
        return [
            'time' => 1234567890,
            'blocks' => [],
            'version' => '2.22.2',
        ];
    }

    public function getInputTypeJsonableClass()
    {
        return new class implements Jsonable
        {
            public function toJson($options = 0)
            {
                return json_encode($this->toArray(), $options);
            }

            public function toArray()
            {
                return [
                    'time' => 1234567890,
                    'blocks' => [],
                    'version' => '2.22.2',
                ];
            }
        };
    }

    public function getInputTypeArrayableClass()
    {
        return new class implements Arrayable
        {
            public function toArray()
            {
                return [
                    'time' => 1234567890,
                    'blocks' => [],
                    'version' => '2.22.2',
                ];
            }
        };
    }
}
