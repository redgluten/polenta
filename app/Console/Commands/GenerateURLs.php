<?php

namespace App\Console\Commands;

use App\Article;
use Illuminate\Console\Command;

class GenerateURLs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urls:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate URLs for articles from titles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = Article::all();

        $bar = $this->output->createProgressBar($articles->count());

        foreach ($articles as $article) {
            $article->url = str_slug($article->title);
            $article->save();
            $bar->advance();
        }

        $bar->finish();
    }
}
