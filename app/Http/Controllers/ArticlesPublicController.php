<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\ArticleWasRead;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Tag;
use Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ArticlesPublicController extends Controller
{
    /**
     * Show resource
     * @param  int|string The article id or url
     * @return View
     */
    public function show($id)
    {
        $article = $this->getByIdOrUrl($id);

        $tagsCloud = Cache::remember('tagsCloud', 300, function() {
            return Tag::getCloud();
        });

        event(new ArticleWasRead($article));

        return view('articles.show', compact('article'));
    }

    /**
     * Get article by id or URL
     * @param int|string $id
     */
    private function getByIdOrUrl($id) : Article
    {
        if (is_numeric($id)) {
            return Article::findOrFail($id);
        }

        return Article::whereUrl($id)->first();
    }

    /**
     * Get random articles among a select result of similar articles
     */
    public function getSimilarArticles(Article $article) : Collection
    {
        $results = \DB::select("SELECT articles.id, count(DISTINCT similar.tag_name) AS shared_tags
            FROM articles
            INNER JOIN ( tagging_tagged AS this_article INNER JOIN tagging_tagged AS similar USING (tag_name) )
            ON similar.taggable_id = articles.id
            WHERE this_article.taggable_id = '" . $article->id . "'
            AND articles.id != this_article.taggable_id
            GROUP BY articles.id
            ORDER BY shared_tags DESC
            LIMIT 4
        ");

        return Article::find(array_pluck($results, 'id'));
    }
}
