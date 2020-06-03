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
        // replace all non letters or digits by -
        $text = preg_replace('/\W+/', '-', $text);
 
        // trim and lowercase
        $text = strtolower(trim($text, '-'));
 
        return $text;
    }
}