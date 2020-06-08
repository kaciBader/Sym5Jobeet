<?php 
// src/Utils/Jobeet.php
 
namespace App\Utils;
class Jobeet
{
	/**
	* Remplace  special char by - 
	*
	* @param string $text
	*
	* @return string $text (the slugified text)
	*/
    static public function slugify($text)
    {
        
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
 
        // trim
        $text = trim($text, '-');
 
        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
 
        // lowercase
        $text = strtolower($text);
 
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
 
        if (empty($text))
        {
            return 'n-a';
        }
 
        return $text;
    }
}