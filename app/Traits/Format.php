<?php namespace App\Traits;

/**
* Formatting helpers
*/
trait Format
{
    /**
     * Format the given bytes as human readable string
     * @param  int  $bytes
     * @param  int $decimals
     * @return string
     */
    public function humanReadableSizeFormat($bytes, $decimals = 2)
    {
        $size = ['o','ko','Mo','Go','To','Po','Eo','Zo','Yo'];

        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}