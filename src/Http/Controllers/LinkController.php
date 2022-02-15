<?php

namespace AlexSabur\OrchidEditorJSField\Http\Controllers;

use AlexSabur\OrchidEditorJSField\Support\Actions\LoadSiteInfo;
use Illuminate\Http\Request;

class LinkController
{
    public function handle(Request $request)
    {
        try {
            $result = app(LoadSiteInfo::class)->handle($request);

            return response()->json([
                'success' => 1,
                'meta' => $result,
            ]);
        } catch (\Throwable $th) {
            report($th);

            return response()->json([
                'success' => 0,
            ]);
        }
    }
}
