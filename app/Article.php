<?php

namespace App;

use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Feed\FeedItem;

class Article extends Model implements FeedItem
{
    use Taggable;
    use SoftDeletes;
    use \App\Traits\FileSaving;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    // Relationships
    // =============

    /**
     * Get the associated issue
     * @return belongsTo The relationship
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }


    // Scopes
    // ======

    /**
     * Get random models
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(\DB::raw('RAND()'));
    }

    /**
     * Scope a query to only include articles that
     * belongs to one of the given issues
     */
    public function scopeBelongsToOneOfTheIssues(Builder $query, array $issuesIds) : Builder
    {
        return $query->whereHas('issue', function($query) use ($issuesIds) {
            $query->whereIn('id', $issuesIds);
        });
    }

    /**
     * Get model with a landscape logo ratio
     */
    public function scopeLogoLandscape($query)
    {
        return $query->where('logo_ratio', 'landscape');
    }

    /**
     * Get models with a square logo ratio
     */
    public function scopeLogoSquare($query)
    {
        return $query->where('logo_ratio', 'square');
    }

    /**
     * Get models with a portrait logo ratio
     */
    public function scopeLogoPortrait($query)
    {
        return $query->where('logo_ratio', 'portrait');
    }

    /**
     * Scope a query to return the given search terms
     * TODO: this is a very **slow** operation that could be
     * be improved with MySQL FULLTEXT indexes
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, $search) : Builder
    {
        return $query
            ->where('title', 'LIKE', '% ' . $search . ' %')
            ->orWhere('title', 'LIKE', $search . ' %')
            ->orWhere('title', 'LIKE', '% ' . $search)
            ->orWhere('chapeau', 'LIKE', '% ' . $search . ' %')
            ->orWhere('chapeau', 'LIKE', $search . ' %')
            ->orWhere('chapeau', 'LIKE', '% ' . $search)
            ->orWhere('content', 'LIKE', '% ' . $search . ' %')
            ->orWhere('content', 'LIKE', $search . ' %')
            ->orWhere('content', 'LIKE', '% ' . $search);
    }

    /**
     * Scope a query to return last articles
     */
    public function scopeLast($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to return most read articles
     * @param  QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopePopular($query)
    {
        return $query->orderBy('reads', 'desc');
    }

    /**
     * Scope a query to not return drafts
     * @param  QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopeNoDrafts($query)
    {
        return $query->whereDraft(false);
    }

    /**
     * Scope a query to return draft articles
     * @param  QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopeDrafts($query)
    {
        return $query->whereDraft(true);
    }

    // Attributes
    // ==========

    /**
     * Returns an excerpt without the HTML tags
     */
    public function getExcerptAttribute()
    {
        $chapeau = strip_tags($this->chapeau, '<b><i><strong><em>');
        $content = strip_tags($this->content, '<b><i><strong><em>');

        return str_limit($chapeau . $content, 200);
    }

    /**
     * Get array of tag names for form-model binding
     * @return array
     */
    public function getTagListAttribute() : array
    {
        return $this->tagNames();
    }

    /**
     * Return created_at as string
     * @return string
     */
    public function getCreatedAtAsStringAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * Get publication date of associated issue
     * @return string
     */
    public function getPublishedAtAttribute()
    {
        if (! $this->has('issue')) {
            return 'inconnue';
        }

        return $this->issue->published_at;
    }

    /**
     * Get a contrasted color from the extracted logo dominant color
     */
    public function getContrastColorAttribute() : array
    {
        $contrastColor = $this->getLogoColorAsAnRgbArray();

        $contrastColor[0] -= 128;
        $contrastColor[1] -= 128;
        $contrastColor[2] -= 128;

        $countSmaller = 0;
        if ($contrastColor[0]<0) $countSmaller++;
        if ($contrastColor[1]<0) $countSmaller++;
        if ($contrastColor[2]<0) $countSmaller++;

        if ($countSmaller == 2) {
            if ($contrastColor[0]>0) $contrastColor[0] = 255;
            if ($contrastColor[1]>0) $contrastColor[1] = 255;
            if ($contrastColor[2]>0) $contrastColor[2] = 255;
        } elseif ($countSmaller == 1) {
            if ($contrastColor[0]<0) $contrastColor[0] = 0;
            if ($contrastColor[1]<0) $contrastColor[1] = 0;
            if ($contrastColor[2]<0) $contrastColor[2] = 0;
        }

        if ($countSmaller == 3 || $countSmaller == 2) {
            if ($contrastColor[0]<0) $contrastColor[0] = 255+$contrastColor[0];
            if ($contrastColor[1]<0) $contrastColor[1] = 255+$contrastColor[1];
            if ($contrastColor[2]<0) $contrastColor[2] = 255+$contrastColor[2];
        }

        $contrastColor[0] = round($contrastColor[0]);
        $contrastColor[1] = round($contrastColor[1]);
        $contrastColor[2] = round($contrastColor[2]);

        return $contrastColor;
    }

    /**
     * Get logo or placeholder path
     */
    public function getLogoOrPlaceholderAttribute()
    {
        if (empty($this->logo)) {
            return 'placeholder.png';
        }

        return $this->logo;
    }

    /**
     * Get words count from content
     * @return int
     */
    public function getWordsCountAttribute()
    {
        return str_word_count($this->content);
    }

    /**
     * Get approximate article lentgh in minutes
     * @return int
     */
    public function getLengthAttribute()
    {
        $length = $this->getWordsCountAttribute() / 260;

        return round($length, 0, PHP_ROUND_HALF_UP);
    }


    // Helpers
    // =======

    /**
     * Get logo color
     * @return array
     */
    public function getLogoColorAsAnRgbArray() : array
    {
        if (empty($this->logo_color)) {
            return [0, 0, 0];
        }

        $color = str_replace('rgb(', '', $this->logo_color);
        $color = str_replace(')', '', $color);

        return explode(',', $color);
    }

    /**
     * Generate the resized images for the logo
     * and process to treat and store the
     * @param  string|UploadedFile $file
     */
    public function generateLogoImages($file)
    {
        $logoPath = $this->saveImageToDisk($file, $this->title, 360, 216);

        // Erase previous files
        if (! empty($this->logo)) {
            @unlink($path . $this->logo);
            @unlink($path . 'original_' . $this->logo);
            @unlink($path . 'large_' . $this->logo);
            @unlink($path . 'thumb_' . $this->logo);
        }

        return $logoPath;
    }

    // Laravel Feed methods
    // ====================

    public function getFeedItemId()
    {
        return $this->id;
    }

    public function getFeedItemTitle()
    {
        return $this->title;
    }

    public function getFeedItemSummary()
    {
        return $this->title;
    }

    public function getFeedItemUpdated() : Carbon
    {
        return $this->updated_at;
    }

    public function getFeedItemLink()
    {
        return url('article.show', $this->id);
    }

    public function getFeedItemAuthor()
    {
        return $this->getAuthorsAsStringAttribute();
    }

    public function getAllFeedItems() : Collection
    {
        return Article::all();
    }
}
