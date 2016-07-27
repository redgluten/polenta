<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    /**
     * Get the associated articles
     * @return hasMany The relationship
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Scope a query to return last $number of articles
     */
    public function scopeLast($query, $number)
    {
        return $query->orderBy('number', 'desc')->limit($number);
    }

    /**
     * Returns published_at as a string
     */
    public function getPublishedAtAttribute($date)
    {
        $date = new Carbon($date);

        return $date->format('d/m/Y');
    }

    /**
     * Returns an appropriated title from number and published_at
     */
    public function getTitleAttribute()
    {
        $formatedDate = Carbon::createFromFormat('d/m/Y', $this->published_at)->formatLocalized('%B %G');

        return 'n°' . $this->number . ', ' . $formatedDate;
    }

    /**
     * Set the issue’s published date
     */
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y', ($value));
    }
}
