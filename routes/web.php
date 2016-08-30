<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::feeds();

Route::auth();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', ['as' => 'welcome', 'uses' => 'HomeController@welcome']);

Route::get('/home', 'HomeController@index');

Route::post('search', ['as' => 'search', 'uses' => 'HomeController@search']);

Route::get('find', ['as' => 'find', 'uses' => 'HomeController@find']);

Route::get('article/{article}', ['as' => 'article.show', 'uses' => 'ArticlesPublicController@show']);

Route::resource('issue', 'IssuesPublicController');
Route::get('issue/{issue}/edito', ['as' => 'issue.edito', 'uses' => 'IssuesPublicController@edito']);

Route::resource('tag', 'TagsController');

Route::get('page/{page}', ['as' => 'page.show', 'uses' => 'PagesPublicController@show']);

Route::post('contact', ['as' => 'contact', 'uses' => 'HomeController@contact']);

// Admin
// =====
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'admin.index', 'uses' => 'AdminController@index']);


    // Backup
    Route::get('backups/{filename}', ['as' => 'backups.download', 'uses' => function ($filename) {
        $filePath = storage_path('app/' . config('laravel-backup.backup.name') . '/' . $filename);
        return response()->download($filePath);
    }]);
    Route::post('backup/run', ['as' => 'backup.run', 'uses' => 'AdminController@backup']);


    Route::post('search', ['as' => 'admin.search', 'uses' => 'ArticlesAdminController@search']);

    Route::resource('friend', 'FriendsAdminController', ['names' => [
        'index'   => 'admin.friend.index',
        'create'  => 'admin.friend.create',
        'store'   => 'admin.friend.store',
        'show'    => 'admin.friend.show',
        'edit'    => 'admin.friend.edit',
        'update'  => 'admin.friend.update',
        'destroy' => 'admin.friend.destroy',
    ]]);

    // Articles
    Route::resource('article', 'ArticlesAdminController', ['names' => [
        'index'   => 'admin.article.index',
        'create'  => 'admin.article.create',
        'store'   => 'admin.article.store',
        'show'    => 'admin.article.show',
        'edit'    => 'admin.article.edit',
        'update'  => 'admin.article.update',
        'destroy' => 'admin.article.destroy',
    ]]);

    Route::get('trash', ['as' => 'admin.article.trash', 'uses' => 'ArticlesAdminController@trash']);

    Route::get('drafts', ['as' => 'admin.article.drafts', 'uses' => 'ArticlesAdminController@drafts']);
    Route::post('article/{article}/untrash', ['as' => 'admin.article.untrash', 'uses' => 'ArticlesAdminController@unTrash']);


    Route::resource('issue', 'IssuesAdminController', ['names' => [
        'index'   => 'admin.issue.index',
        'create'  => 'admin.issue.create',
        'store'   => 'admin.issue.store',
        'show'    => 'admin.issue.show',
        'edit'    => 'admin.issue.edit',
        'update'  => 'admin.issue.update',
        'destroy' => 'admin.issue.destroy',
    ]]);

    Route::resource('page', 'PagesAdminController', ['names' => [
        'index'   => 'admin.page.index',
        'create'  => 'admin.page.create',
        'store'   => 'admin.page.store',
        'show'    => 'admin.page.show',
        'edit'    => 'admin.page.edit',
        'update'  => 'admin.page.update',
        'destroy' => 'admin.page.destroy',
    ]]);

    Route::resource('location', 'LocationsAdminController', ['names' => [
        'index'   => 'admin.location.index',
        'create'  => 'admin.location.create',
        'store'   => 'admin.location.store',
        'show'    => 'admin.location.show',
        'edit'    => 'admin.location.edit',
        'update'  => 'admin.location.update',
        'destroy' => 'admin.location.destroy',
    ]]);

});
