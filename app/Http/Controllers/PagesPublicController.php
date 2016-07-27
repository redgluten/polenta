<?php

namespace App\Http\Controllers;

use App\Page;
use App\Http\Requests;
use Illuminate\Http\Request;

class PagesPublicController extends Controller
{
    /**
     * Show the resource.
     * @param  int|string $url
     * @return View
     */
    public function show($url)
    {
        if (is_numeric($url)) {
            $page = Page::findOrFail($url);
        } else {
            $page = Page::whereUrl($url)->first();
        }

        return view('pages.show', compact('page'));
    }
}
