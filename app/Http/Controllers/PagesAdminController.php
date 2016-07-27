<?php

namespace App\Http\Controllers;

use App\Page;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SavePageRequest;

class PagesAdminController extends Controller
{
    use \App\Traits\FileSaving;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('title', 'asc')->paginate(10);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SavePageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavePageRequest $request)
    {
        $page = new Page();

        $this->savePage($request, $page);

        return redirect()
            ->route('admin.page.index')
            ->with('message', 'La page ' . $page->title . ' a bien été créée');
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $page = Page::findOrFail($id);
        } else {
            $page = Page::whereUrl($id)->first();
        }

        return view('pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SavePageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SavePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        $this->savePage($request, $page);

        return redirect()
            ->route('admin.page.index')
            ->with('message', 'La page ' . $page->title . ' a bien été mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = Page::findOrFail($id)->title;
        Page::destroy($id);

        return redirect()
            ->route('admin.page.index')
            ->with('message', 'La page ' . $title . ' a bien été supprimée');
    }

    /**
     * Save page to DB
     * @param  SavePageRequest  $request
     * @param  Page $page
     * @return Page
     */
    public function savePage(SavePageRequest $request, Page $page)
    {
        $page->title   = $request->title;
        $page->content = $request->content;

        if ($request->has('url')) {
            $page->url = $request->url;
        } else {
            $page->url = str_slug($page->title);
        }

        $page->display_in_menu = $request->display_in_menu;

        $page->display_in_footer = $request->display_in_footer;

        $page->save();

        return $page;
    }
}
