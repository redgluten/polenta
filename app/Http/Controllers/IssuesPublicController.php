<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Issue;
use App\Location;
use App\Tag;
use Cache;
use Illuminate\Http\Request;

class IssuesPublicController extends Controller
{
    /**
     * Index of issues
     * @return View
     */
    public function index()
    {
        $issues = Issue::orderBy('number', 'desc')->with('articles')->get();
        $tags = Cache::remember('tagsCloud', 300, function() {
            return Tag::getCloud();
        });

        return view('issues.index', compact('issues', 'tags'));
    }

    /**
     * Show issue
     * @param  int    $id
     * @return View
     */
    public function show($id)
    {
        $issue = Issue::findOrFail($id);

        return view('issues.show', compact('issue'));
    }

    /**
     * Display full editorial
     * @param  int $id
     * @return View
     */
    public function edito($id)
    {
        $issue = Issue::findOrFail($id);

        return view('issues.edito', compact('issue'));
    }
}
