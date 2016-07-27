<?php

use App\Location;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function index()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin)
             ->visit(route('admin.location.index'))
             ->seePageIs('/admin/location')
             ->see('Lieux de distribution');
    }

    /** @test */
    function create_new_location()
    {
        $admin   = $this->getAdminUser();
        $location = factory(Location::class)->make();
        $this->actingAs($admin)
             ->visit(route('admin.location.create'))
             ->seePageIs('/admin/location/create')
             ->see('Nouveau lieu de distribution')
             ->type($location->name, 'name')
             ->type($location->description, 'description')
             ->type($location->longitude, 'longitude')
             ->type($location->latitude, 'latitude')
             ->type($location->city, 'city')
             ->press('Enregistrer')
             ->see('Le lieu de distribution ' . $location->name . ' a bien été créé');
    }

    /** @test */
    function update_location()
    {
        $admin   = $this->getAdminUser();
        $location = factory(Location::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.location.edit', $location))
             ->seePageIs('/admin/location/' . $location->id . '/edit')
             ->see('Modifier')
             ->type('Jojo', 'name')
             ->press('Enregistrer')
             ->see('Le lieu de distribution Jojo a bien été mis à jour');
    }

    /** @test */
    function destroy_location()
    {
        $admin = $this->getAdminUser();
        $location = factory(Location::class)->create();
        $this->actingAs($admin)
             ->visit(route('admin.location.index'))
             ->seePageIs('/admin/location/')
             ->see($location->name)
             ->click('modal-delete-' . $location->id)
             ->see('Êtes-vous sur de vouloir supprimer le lieu ' . $location->name . ' ?')
             ->press('delete-resource-' . $location->id)
             ->see('Le lieu de distribution ' . $location->name . ' a été correctement supprimé');
    }
}