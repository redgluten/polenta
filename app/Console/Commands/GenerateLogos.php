<?php

namespace App\Console\Commands;

use App\Article;
use Illuminate\Console\Command;

class GenerateLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logos:generate {article?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate logos for the given articles or all articles if none provided';

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
        if (empty($this->argument('article'))) {
            $articles = Article::where('logo', '!=', null)->get();
        } elseif (is_array($this->argument('article'))) {
            $articles = Article::whereIn('id', $this->argument('article'))->get();
        } else {
            $articles = Article::where('id', $this->argument('article'))->get();
        }

        $bar = $this->output->createProgressBar($articles->count());

        foreach ($articles as $article) {
            $logoPath = $article->generateLogoImages($article->logo, $article);
            $article->logo       = $logoPath;
            $article->logo_ratio = $article->getLogoRatio(public_path('uploads/original_' . $logoPath));
            $article->logo_color = $article->getLogoColorAsCssFormatedRgbValues(public_path('uploads/original_' . $logoPath));
            $article->save();
            $bar->advance();
        }

        $bar->finish();
    }
}
