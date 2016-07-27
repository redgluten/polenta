<?php

use App\Issue;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IssueTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function index()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.issue.index'))
             ->seePageIs('/admin/issue')
             ->see('Numéros');
    }

    /** @test */
    function create_new_issue()
    {
        $admin = $this->getAdminUser();
        $issue = factory(Issue::class)->make();
        $this->actingAs($admin)
             ->visit(route('admin.issue.create'))
             ->seePageIs('/admin/issue/create')
             ->see('Nouveau numéro')
             ->type($issue->published_at, 'published_at')
             ->type($issue->number, 'number')
             ->type($issue->masthead, 'masthead')
             ->type($issue->editorial_content, 'editorial_content')
             ->type($issue->editorial_title, 'editorial_title')
             ->press('Enregistrer')
             ->see('Le numéro ' . $issue->title . ' a bien été créé');
    }

    /** @test */
    function show_issue()
    {
        $issue = factory(Issue::class)->create();
        $this->visit(route('issue.show', $issue))
            ->seePageIs('issue/' . $issue->id)
            ->see($issue->title);
    }

    /** @test */
    function update_issue()
    {
        $admin = $this->getAdminUser();
        $issue = factory(Issue::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.issue.edit', $issue))
             ->seePageIs('/admin/issue/' . $issue->id . '/edit')
             ->see('Modifier')
             ->type('Rototo', 'masthead')
             ->press('Enregistrer')
             ->see('Le numéro ' . $issue->title . ' a bien été mis à jour');
    }

    /** @test */
    function destroy_issue()
    {
        $admin = $this->getAdminUser();
        $issue = factory(Issue::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.issue.index'))
             ->seePageIs('/admin/issue/')
             ->see($issue->title)
             ->click('modal-delete-' . $issue->id)
             ->see('Êtes-vous sur de vouloir supprimer le numéro ' . $issue->title . ' ?')
             ->press('delete-resource-' . $issue->id)
             ->see('Le numéro ' . $issue->title . ' a bien été supprimé');
    }
}