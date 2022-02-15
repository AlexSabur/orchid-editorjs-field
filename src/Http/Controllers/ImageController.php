<?php

namespace AlexSabur\OrchidEditorJSField\Http\Controllers;

use AlexSabur\OrchidEditorJSField\Support\Actions\LoadImage;
use Illuminate\Http\Request;
use Orchid\Platform\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function byUrl(Request $request)
    {
        try {
            $result = app(LoadImage::class)->loadByUrl($request);

            return $this->success($result);
        } catch (\Throwable $th) {
            report($th);

            return $this->fail();
        }
    }

    public function byFile(Request $request)
    {
        try {
            $result = app(LoadImage::class)->loadByRequest($request);

            return $this->success($result);
        } catch (\Throwable $th) {
            report($th);

            return $this->fail();
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
}
