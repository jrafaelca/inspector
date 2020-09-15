<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewInspectionRequest;
use App\Http\Resources\InspectionResource;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InspectionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param NewInspectionRequest $request
     * @return InspectionResource
     */
    public function __invoke(NewInspectionRequest $request)
    {
        $url = $request->validated()['url'];

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();

        if (@$dom->loadHTMLFile($url) === false) {
            throw ValidationException::withMessages([
                'url' => 'No se pudo localizar la URL que ingresó.'
            ]);
        }

        $dom->loadHTMLFile($url);

        $page = simplexml_import_dom($dom);

        $stylesheets = collect($page->xpath('//link[@rel="stylesheet"]'));
        $images      = collect($page->xpath('//img[@src]'));
        $style       = $page->xpath('//style');

        $inspection = [
            'images'      => $images->count(),
            'stylesheets' => $stylesheets->count(),
            'style'       => (boolean) $style,
        ];

        return new InspectionResource($inspection);
    }
}
