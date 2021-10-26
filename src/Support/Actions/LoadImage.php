<?php

namespace AlexSabur\OrchidEditorJSField\Support\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;

class LoadImage
{
    static public $loadByUrlCallback;

    static public $loadByRequestCallback;

    public static function loadByUrlUsing($callback)
    {
        # code...
    }

    public static function loadByRequestUsing($callback)
    {
        # code...
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function loadByUrl(Request $request)
    {
        if (static::$loadByUrlCallback) {
            return call_user_func(static::$loadByUrlCallback, $request);
        }


    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function loadByRequest(Request $request)
    {
        if (static::$loadByRequestCallback) {
            return call_user_func(static::$loadByRequestCallback, $request);
        }

        $image = $request->file('image');

        $model = $this->createModel($image, $request);

        return [
            'url' => $model->url
        ];
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
