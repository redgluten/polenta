<?php

namespace App\Http\Controllers;

use Cache;
use App\Issue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveIssueRequest;

class IssuesAdminController extends Controller
{
    use \App\Traits\FileSaving;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::orderBy('number', 'desc')->paginate(10);

        return view('admin.issues.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.issues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveIssueRequest $request)
    {
        $issue = new Issue();

        $this->saveIssue($request, $issue);

        return redirect()
            ->route('admin.issue.index')
            ->with('message', 'Le numéro ' . $issue->title . ' a bien été créé');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = Issue::findOrFail($id);

        return view('admin.issues.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue  = Issue::findOrFail($id);

        return view('admin.issues.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveIssueRequest $request, $id)
    {
        $issue = Issue::findOrFail($id);

        $this->saveIssue($request, $issue);

        return redirect()
            ->route('admin.issue.index')
            ->with('message', 'Le numéro ' . $issue->title . ' a bien été mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = Issue::findOrFail($id)->title;
        Issue::destroy($id);

        return redirect()
            ->route('admin.issue.index')
            ->with('message', 'Le numéro ' . $title . ' a bien été supprimé');
    }

    /**
     * Save issue to DB
     */
    public function saveIssue(SaveIssueRequest $request, Issue $issue) : Issue
    {
        $issue->number            = $request->number;
        $issue->presentation      = $request->presentation;
        $issue->masthead          = $request->masthead;
        $issue->published_at      = $request->published_at;
        $issue->editorial_title   = $request->editorial_title;
        $issue->editorial_content = $request->editorial_content;

        $cover = $this->saveImageToDisk($request->file('cover'), str_slug($issue->title), 300, 424);
        if ($cover != false) {
            $issue->cover = $cover;
        }

        $print_file = $this->savePdfToDisk($request->file('print_file'), str_slug($issue->title));
        if ($print_file != false) {
            $issue->print_file = $print_file;
        }

        $issue->save();

        Cache::forget('lastIssue');

        return $issue;
    }
}
