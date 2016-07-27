<?php

namespace App\Listeners;

use App\Events\ArticleWasRead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateArticleReadsCount implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleWasRead  $event
     * @return void
     */
    public function handle(ArticleWasRead $event)
    {
        // Update the reads counter without updating the timestamp
        $event->article->reads++;
        $event->article->timestamps = false;
        $event->article->save();
    }
}
