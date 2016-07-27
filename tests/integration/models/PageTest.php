<?php

use App\Page;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function index()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.page.index'))
             ->seePageIs('/admin/page')
             ->see('Les pages');
    }

    /** @test */
    function create_new_page()
    {
        $admin   = $this->getAdminUser();
        $page = factory(Page::class)->make();
        $this->actingAs($admin)
             ->visit(route('admin.page.create'))
             ->seePageIs('/admin/page/create')
             ->see('Ajouter une page')
             ->type($page->title, 'title')
             ->type($page->content, 'content');

        if ($page->display_in_menu) {
            $this->check('display_in_menu');
        }

        if ($page->display_in_footer) {
            $this->check('display_in_footer');
        }

        $this->press('Ajouter')
             ->see('La page ' . $page->title . ' a bien été créée');
    }

    /** @test */
    function update_page()
    {
        $admin = $this->getAdminUser();
        $page  = factory(Page::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.page.edit', $page))
             ->seePageIs('/admin/page/' . $page->id . '/edit')
             ->see('Modifier')
             ->type('Jojo', 'title')
             ->press('Enregistrer')
             ->see('La page Jojo a bien été mise à jour');
    }

    /** @test */
    function destroy_page()
    {
        $admin = $this->getAdminUser();
        $page  = factory(Page::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.page.index'))
             ->seePageIs('/admin/page/')
             ->see($page->title)
             ->click('modal-delete-' . $page->id)
             ->see('Êtes-vous sur de vouloir supprimer la page ' . $page->title . ' ?')
             ->press('delete-resource-' . $page->id)
             ->see('La page ' . $page->title . ' a bien été supprimée');
    }
}