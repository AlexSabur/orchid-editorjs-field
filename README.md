# Orchid Editorjs Field

[![GitHub Workflow Status](https://github.com/AlexSabur/orchid-editorjs-field/workflows/Run%20tests/badge.svg)](https://github.com/AlexSabur/orchid-editorjs-field/actions)
[![styleci](https://styleci.io/repos/188413486/shield)](https://styleci.io/repos/188413486)

[![Packagist](https://img.shields.io/packagist/v/AlexSabur/orchid-editorjs-field.svg)](https://packagist.org/packages/AlexSabur/orchid-editorjs-field)
[![Packagist](https://poser.pugx.org/AlexSabur/orchid-editorjs-field/d/total.svg)](https://packagist.org/packages/AlexSabur/orchid-editorjs-field)
[![Packagist](https://img.shields.io/packagist/l/AlexSabur/orchid-editorjs-field.svg)](https://packagist.org/packages/AlexSabur/orchid-editorjs-field)

Package description: CHANGE ME

## Installation

Install via composer
```bash
composer require alexsabur/orchid-editorjs-field:dev-master
```

## Usage

```php

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                EditorJS::make('mydata')->tools([
                    MarkerTool::make('marker'),
                    ImageTool::make('picture')
                        ->shortcut('CMD+SHIFT+I'),
                    HeaderTool::make('header')
                        ->inlineToolbar(false)
                        ->config('placeholder', 'My header'),
                ])
            ]),
        ];
    }

```

## Security

If you discover any security related issues, please email alexsabur@live.ru
instead of using the issue tracker.

## Credits

- [Alex](https://github.com/AlexSabur/orchid-editorjs-field)
- [All contributors](https://github.com/AlexSabur/orchid-editorjs-field/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
