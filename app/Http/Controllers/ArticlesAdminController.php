<?php

namespace App\Http\Controllers;

use Cache;
use App\User;
use App\Issue;
use App\Article;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArticleRequest;

class ArticlesAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->with('issue')->paginate(5);
        $issues   = Issue::all()->pluck('title', 'id');

        return view('admin.articles.index', compact('articles', 'issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users  = User::pluck('name', 'id')->all();
        $issues = Issue::get()->pluck('title', 'id')->all();
        $tags   = Article::existingTags()->pluck('name');

        return view('admin.articles.create', compact('users', 'issues', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SaveArticleRequest $request)
    {
        $article = new Article();

        $this->saveArticle($request, $article);

        return redirect()
            ->route('admin.article.index')
            ->with('message', 'L’article ' . $article->title . ' a bien été créé');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $users   = User::pluck('name', 'id')->all();
        $issues  = Issue::get()->pluck('title', 'id')->all();
        $tags    = Article::existingTags()->pluck('name', 'name');

        return view('admin.articles.edit', compact('article', 'users', 'issues', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SaveArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);

        $this->saveArticle($request, $article);

        return redirect()
            ->route('admin.article.index')
            ->with('message', 'L’article ' . $article->title . ' a bien été mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $title = $article->title;

        $article->delete();

        return redirect()
            ->route('admin.article.index')
            ->with('message', 'L’article ' . $title . ' a bien été déplacé dans la corbeille');
    }

    /**
     * Save article to DB
     */
    private function saveArticle(SaveArticleRequest $request, Article $article) : Article
    {
        // Save the manually submited url or generate one
        if ($request->has('url')) {
            $article->url = $request->url;
        } else {
            $article->url = str_slug($request->title);
        }

        $article->title    = $request->title;
        $article->chapeau  = $request->chapeau;
        $article->content  = $request->content;
        $article->aside1   = $request->aside1;
        $article->aside2   = $request->aside2;
        $article->issue_id = $request->issue_id;

        $logoPath = $article->generateLogoImages($request->file('logo'), $article);
        if ($logoPath) {
            $article->logo       = $logoPath;
            $article->logo_ratio = $article->getLogoRatio(public_path('uploads/original_' . $logoPath));
            $article->logo_color = $article->getLogoColorAsCssFormatedRgbValues(public_path('uploads/original_' . $logoPath));
        }

        $article->logo_caption = $request->logo_caption;

        $article->save();

        if ($request->has('tag_list') && is_array($request->tag_list)) {
            $article->retag(implode(',', $request->tag_list));
        } else {
            $article->retag([]);
        }

        Cache::forget('lastIssue');

        return $article;
    }

    /**
     * Search articles
     * @param  Request $request
     * @return View
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'search'       => 'string|max:3000',
            'issue_list'   => 'array',
            'issue_list.*' => 'exists:issues,id',
        ]);

        $articles = Article::orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $articles = $articles->search($request->search);
        }

        if ($request->has('issue_list')) {
            $articles = $articles->BelongsToOneOfTheIssues($request->issue_list);
        }

        $articles = $articles->paginate(10);

        $issues = Issue::all()->pluck('title', 'id');

        return view('admin.search', compact('search', 'articles', 'issues'));
    }
}
