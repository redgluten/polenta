<?php

namespace App\Providers;

use Cache;
use Schema;
use App\Page;
use App\Issue;
use App\Friend;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Convert instances of Faker to french locale
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('fr_FR');
        });

        view()->share('polenta', 'Polenta&#xA0;! Le journal qui ne rend pas i-Diot');
        view()->share('slogan', 'Enquête • Jeux • Poésie • Reportages • Dessin • Théâtre');

        // Pass the last issue to every view
        if (Schema::hasTable('issues')) {
            view()->share('lastIssue', Cache::remember('lastIssue', 600, function() {
                return Issue::last(1)->with(['articles' => function($query) {
                    $query->orderBy('title', 'ASC');
                }])->first();
            }));
        }

        // Pass the friend list to every view
        if (Schema::hasTable('friends')) {
            view()->share('friendList', Cache::remember('friendList', 200, function() {
                return Friend::pluck('name', 'url');
            }));
        }

        // Pass the pages links to every view
        if (Schema::hasTable('pages')) {
            $menuPages = Page::orderBy('title', 'asc')->where('display_in_menu', '=', true)->pluck('title', 'url')->all();
            view()->share('menuPages', $menuPages);

            $footerPages = Page::orderBy('title', 'asc')->where('display_in_footer', '=', true)->pluck('title', 'url')->all();
            view()->share('footerPages', $footerPages);
        }

        // Pass the locations to every view
        if (Schema::hasTable('locations')) {
            view()->share('locations', Cache::rememberForever('locations', function() {
                return \App\Location::all();
            }));
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
