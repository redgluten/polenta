<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::feeds();

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::auth();

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

        Route::get('backups/{filename}', ['as' => 'backups.download', 'uses' => function ($filename) {
            $filePath = storage_path('app/' . config('laravel-backup.backup.name') . '/' . $filename);
            return response()->download($filePath);
        }]);

        Route::post('backup/run', ['as' => 'backup.run', 'uses' => 'AdminController@backup']);


        Route::post('search', ['as' => 'admin.search', 'uses' => 'ArticlesAdminController@search']);

        Route::resource('friend', 'FriendsAdminController');

        // Articles
        Route::resource('article', 'ArticlesAdminController');

        Route::get('trash', ['as' => 'admin.article.trash', 'uses' => 'ArticlesAdminController@trash']);

        Route::get('drafts', ['as' => 'admin.article.drafts', 'uses' => 'ArticlesAdminController@drafts']);
        Route::post('article/{article}/untrash', ['as' => 'admin.article.untrash', 'uses' => 'ArticlesAdminController@unTrash']);


        Route::resource('issue', 'IssuesAdminController');
        Route::resource('page', 'PagesAdminController');
        Route::resource('location', 'LocationsAdminController');
    });
});
