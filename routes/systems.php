<?php

use AlexSabur\OrchidEditorJSField\Http\Controllers\ImageController;

$this->router->post('image-by-file', [ImageController::class, 'byFile'])
    ->name('systems.editorjs.image-by-file');
$this->router->post('image-by-url', [ImageController::class, 'byUrl'])
    ->name('systems.editorjs.image-by-url');
