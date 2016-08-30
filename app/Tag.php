<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Model
{
    protected $table = 'tagging_tags';

    public function getArticles() : Builder
    {
        return Article::withAllTags($this->name);
    }

    /**
     * Returns a collection of tag arrays with size info for cloud
     */
    public static function getCloud() : Collection
    {
        // Get occurences of each tag for the given Class
        $occurences = \DB::table('tagging_tags')->pluck('count', 'id')->all();

        // Total occurences of each category
        $total = array_sum($occurences);

        $tags = collect([]);
        foreach ($occurences as $id => $occurence) {

            $tag = \DB::table('tagging_tags')->where('id', $id)->first();

            // Apperance percentage of the tag among activities
            $percentage = round(($occurence / $total) * 100);

            // Set the keyword for CSS
            switch (true) {
                case $percentage > 25 :
                    $size = 'humongous';
                    break;

                case $percentage > 15 :
                    $size = 'large';
                    break;

                case $percentage > 5 :
                    $size = 'medium';
                    break;

                default:
                    $size = 'small';
                    break;
            }

            $tag->size = $size;

            $tags->push($tag);
        }

        return $tags;
    }
}
