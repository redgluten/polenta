<?php namespace App\Traits;

trait Sanitize
{
    /**
     * Remove spaces before validation
     * @param  string $string
     * @return string
     */
    public function trimSpaces($string)
    {
        return str_replace(' ', '', $string);
    }

    /**
     * Add http:// to the given string if not present
     * @param  string $url
     *
     * @return string $url
     */
    public static function addHttp($url)
    {
        if ($url != '' and ! preg_match("~^(?:f|ht)tps?://~i", $url) ) {
            $url = "http://" . $url;
        }

        return $url;
    }
}
