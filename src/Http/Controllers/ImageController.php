<?php

namespace AlexSabur\OrchidEditorJSField\Http\Controllers;

use AlexSabur\OrchidEditorJSField\Support\Actions\LoadImage;
use Illuminate\Http\Request;
use Orchid\Platform\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Orchid\Attachment\File;

class ImageController extends Controller
{
    public function byUrl(Request $request)
    {
        if (!$stream = @fopen($request->url, 'r')) {
            return $this->fail();
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'editorjs-image');
        file_put_contents($temporaryFile, $stream);

        $filename = basename(parse_url($request->url, PHP_URL_PATH));
        $filename = str_replace('%20', ' ', $filename);

        if ($filename === '') {
            $filename = 'file';
        }

        $mediaExtension = explode('/', mime_content_type($temporaryFile));

        if (!Str::contains($filename, '.')) {
            $filename = "{$filename}.{$mediaExtension[1]}";
        }


        $file = new UploadedFile($temporaryFile, $filename);

        $model = $this->createModel($file, $request);

        return $this->success([
            'url' => $model->url
        ]);
    }

    public function byFile(Request $request)
    {
        try {
            $result = app(LoadImage::class)->loadByRequest($request);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    protected function fail()
    {
        return response()->json([
            'success' => 0,
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
