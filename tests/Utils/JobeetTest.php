<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Utils\Jobeet ;

class JobeetTest extends TestCase
{
	/*
    public function testSomething()
    {
        $this->assertTrue(true);
    }
    */
    public function testSlugify()
    {
    	//test a slugified uinput text
    	$this->assertEquals('develloper', Jobeet::slugify('develloper'));
    	// test space in the meddle of the input text
    	$this->assertEquals('web-develloper', Jobeet::slugify('web develloper'));
    	// test space as preffix of the input text
    	$this->assertEquals('web-develloper', Jobeet::slugify(' web develloper'));
    	// test space as suffix of the input text
    	$this->assertEquals('web-develloper', Jobeet::slugify('web develloper '));
    	// test special char in the input text (ex  : ,)
    	$this->assertEquals('web-develloper', Jobeet::slugify('web,develloper'));
    	// test an empty input text
    	$this->assertEquals('n-a', Jobeet::slugify(''));

    	$this->assertEquals('n-a', Jobeet::slugify(' - '));

    	// test a french input text
    	if (function_exists('iconv'))
		{
  			$this->assertEquals('developpeur-web', Jobeet::slugify('Développeur Web'));
		}
    }
}
