<?php

namespace AlexSabur\OrchidEditorJSField\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Platform\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;

class ImageController extends Controller
{
    public function byUrl(Request $request)
    {
        dd($request->all());
    }

    public function byFile(Request $request)
    {
        $image = $request->file('image');

        $model = $this->createModel($image, $request);

        return $this->success([
            'url' => $model->url
        ]);
    }

    protected function success(array $data)
    {
        return response()->json([
            'success' => 1,
            'file' => $data,
        ]);
    }

    protected function createModel(UploadedFile $file, Request $request)
    {
        $model = app()->make(File::class, [
            'file'  => $file,
            'disk'  => $request->get('storage'),
            'group' => $request->get('group'),
        ])->load();

        $model->url = $model->url();

        return $model;
    }
}
