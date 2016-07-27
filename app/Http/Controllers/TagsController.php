<?php

namespace App\Http\Controllers;

use Cache;
use App\Tag;
use App\Article;
use App\Http\Requests;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Index of tags
     * @return View
     */
    public function index()
    {
        $tags = Cache::remember('tagsCloud', 300, function() {
            return Tag::getCloud();
        });

        return view('tags.index', compact('tags'));
    }

    /**
     * Show tag
     * @param  Tag    $tag
     * @return View
     */
    public function show(Tag $tag)
    {
        $articles = $tag->getArticles()->paginate(10);

        return view('tags.show', compact('tag', 'articles'));
    }
}
