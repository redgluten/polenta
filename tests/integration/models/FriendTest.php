<?php

use App\Friend;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FriendTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function index()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.friend.index'))
             ->seePageIs('/admin/friend')
             ->see('Copains');
    }

    /** @test */
    function create_new_friend()
    {
        $admin   = $this->getAdminUser();
        $friend = factory(Friend::class)->make();
        $this->actingAs($admin)
             ->visit(route('admin.friend.create'))
             ->seePageIs('/admin/friend/create')
             ->see('Nouveau copain')
             ->type($friend->name, 'name')
             ->type($friend->url, 'url')
             ->press('Enregistrer')
             ->see('Copain-ine ' . $friend->name . ' a bien été créé-e');
    }

    /** @test */
    function update_friend()
    {
        $admin = $this->getAdminUser();
        $friend  = factory(Friend::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.friend.edit', $friend))
             ->seePageIs('/admin/friend/' . $friend->id . '/edit')
             ->see('Modifier')
             ->type('Jojo', 'name')
             ->press('Enregistrer')
             ->see('Les infos de Jojo ont bien été mises à jour');
    }

    /** @test */
    function destroy_friend()
    {
        $admin = $this->getAdminUser();
        $friend  = factory(Friend::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.friend.index'))
             ->seePageIs('/admin/friend/')
             ->see($friend->name)
             ->click('modal-delete-' . $friend->id)
             ->see('Êtes-vous sur de vouloir supprimer ' . $friend->name . ' ?')
             ->press('delete-resource-' . $friend->id)
             ->see('Copain-ine ' . $friend->name . ' a bien été supprimé-e :/');
    }
}