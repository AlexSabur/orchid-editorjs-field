<?php

namespace AlexSabur\OrchidEditorJSField\Support\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class LoadSiteInfo
{
    public static $callback;

    public static function callbackUsing($callback)
    {
        static::$callback = $callback;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        if (static::$callback) {
            return call_user_func(static::$callback, $request);
        }

        $body = Http::withOptions(['verify' => false])->get($request->input('url'))->throw()->body();

        $result = [];

        preg_match('/<title>(.*)<\/title>/is', $body, $matches);

        if ($matches > 1) {
            Arr::set($result, 'title', $matches[1]);
        }

        if ($description = $this->getMeta($body, 'description')) {
            Arr::set($result, 'description', $description);
        }

        if ($image = $this->getMeta($body, 'og:image')) {
            Arr::set($result, 'image.url', $image);
        }

        return $result;
    }

    protected function getMeta($html, $key)
    {
        preg_match("/<meta.*?name=(\"|\'){$key}(\"|\').*?content=(\"|\')(.*?)(\"|\')/i", $html, $matches);

        if (count($matches) > 4) {
            return trim($matches[4]);
        }

        preg_match("/<meta.*?content=(\"|\')(.*?)(\"|\').*?name=(\"|\'){$key}(\"|\')/i", $html, $matches);
        if (count($matches) > 2) {
            return trim($matches[2]);
        }

        return null;
    }
}
