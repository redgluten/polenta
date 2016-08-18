<?php

use App\Article;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function index()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.article.index'))
             ->seePageIs('/admin/article')
             ->see('Articles');
    }

    /** @test */
    function index_should_not_display_drafts()
    {
        $admin = $this->getAdminUser();
        $article = factory(Article::class)->create();
        $article->draft = true;
        $article->save();
        $this->actingAs($admin)
             ->visit(route('admin.article.index'))
             ->dontSee($article->title);
    }

    /** @test */
    function drafts()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.article.drafts'))
             ->seePageIs('/admin/drafts')
             ->see('Brouillons');
    }

    /** @test */
    function drafts_should_not_display_published_articles()
    {
        $admin = $this->getAdminUser();
        $article = factory(Article::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.article.drafts'))
             ->dontSee($article->title);
    }

    /** @test */
    function trash()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.article.trash'))
             ->seePageIs('/admin/trash')
             ->see('Corbeille');
    }

    /** @test */
    function create_new_article()
    {
        $admin   = $this->getAdminUser();
        $article = factory(Article::class)->make();
        $this->actingAs($admin)
             ->visit(route('admin.article.create'))
             ->seePageIs('/admin/article/create')
             ->see('Nouvel article')
             ->type($article->title, 'title')
             ->type($article->chapeau, 'chapeau')
             ->type($article->content, 'content')
             ->select($article->issue_id, 'issue_id')
             ->press('Enregistrer')
             ->see('L’article ' . $article->title . ' a bien été créé');
    }

    /** @test */
    function show_article()
    {
        $article = factory(Article::class)->create();
        $this->visit(route('article.show', $article))
            ->seePageIs('article/' . $article->id)
            ->see($article->title);
    }

    /** @test */
    function update_article()
    {
        $admin   = $this->getAdminUser();
        $article = factory(Article::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.article.edit', $article))
             ->seePageIs('/admin/article/' . $article->id . '/edit')
             ->see('Modifier')
             ->type('Jojo', 'title')
             ->press('Enregistrer')
             ->see('L’article Jojo a bien été mis à jour');
    }

    /** @test */
    function destroy_article()
    {
        $admin = $this->getAdminUser();
        $article = factory(Article::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.article.index'))
             ->seePageIs('/admin/article/')
             ->see($article->title)
             ->click('modal-delete-' . $article->id)
             ->see('Êtes-vous sur de vouloir déplacer l’article ' . $article->title . ' vers la corbeille ?')
             ->press('delete-resource-' . $article->id)
             ->see('L’article ' . $article->title . ' a bien été déplacé dans la corbeille');
    }

    /** @test */
    function untrash()
    {
        $admin = $this->getAdminUser();
        $article = factory(Article::class)->create();
        $article->delete();
        $this->actingAs($admin)
            ->visit(route('admin.article.trash'))
            ->seePageIs('/admin/trash')
            ->see($article->title)
            ->press('untrash-' . $article->id)
            ->seePageIs('/admin/drafts')
            ->see('L’article ' . $article->title . ' a été converti en brouillon');
    }
}
