<?php

namespace AlexSabur\OrchidEditorJSField\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LinkController
{
    public function __invoke(Request $request)
    {
        $email = config('orchid-editorjs-field.link.urlmeta.email');
        $apikey = config('orchid-editorjs-field.link.urlmeta.apikey');

        $responce = (new Client())->get('https://api.urlmeta.org/', [
            'http_errors' => false,
            'auth' => [
                $email,
                $apikey,
            ],
            'query' => [
                'url' => $request->url,
            ]
        ]);

        $data = json_decode((string) $responce->getBody(), true);

        if (Arr::get($data, 'result.status') === 'OK') {
            $meta = [];

            $this->setIfHas($data, 'meta.title', $meta, 'title');
            $this->setIfHas($data, 'meta.description', $meta, 'description');
            $this->setIfHas($data, ['meta.site.logo', 'meta.site.image', 'meta.image'], $meta, 'image.url');

            return response()->json([
                'success' => 1,
                'meta' => $meta
            ]);
        }

        return response()->json([
            'success' => 0
        ]);
    }

    protected function setIfHas($source, $sourceKey, &$to, $toKey)
    {
        foreach ((array) $sourceKey as $key) {
            if (Arr::has($source, $key)) {
                Arr::set($to, $toKey, Arr::get($source, $key));
            }
        }
    }
}
