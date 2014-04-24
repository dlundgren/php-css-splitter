<?php
/**
 * PHP CSS Splitter
 *
 * Based on https://github.com/zweilove/css_splitter but written for PHP
 *
 * @author    David Lundgren
 * @copyright 2014, David Lundgren. All Rights Reserved.
 * @license   MIT
 */
namespace CssSplitter\Tests;

use CssSplitter\Splitter;

class SplitterTest
	extends \PHPUnit_Framework_TestCase
{
	public static function provideSplitFilesAndExpectedResults()
	{
		$cssDirectory = __DIR__ . '/../_files/CssData';
		return array(
			array("$cssDirectory/basic-with-charset-1.expected.css", "$cssDirectory/basic-with-charset.css", 1, 2),
			array("$cssDirectory/basic-with-charset-2.expected.css", "$cssDirectory/basic-with-charset.css", 2, 2),
		);
	}

	public static function provideCssFilesAndCounts()
	{
		$cssDirectory = __DIR__ . '/../_files/CssData';
		return array(
			array(file_get_contents("$cssDirectory/basic.css"), 5),
			array(file_get_contents("$cssDirectory/basic-with-charset.css"), 5),
			array(file_get_contents("$cssDirectory/basic-with-media-query.css"), 6),
			array(file_get_contents("$cssDirectory/basic-with-media-queries.css"), 11),
			array(file_get_contents("$cssDirectory/media-queries.css"), 3),
		);
	}

	/**
	 * @dataProvider provideCssFilesAndCounts
	 */
	public function testCountSelectors($css, $expectedCount)
	{
		$splitter = new Splitter();
		self::assertEquals($expectedCount, $splitter->countSelectors($css));
	}

	public function testCountSplitDefaultSize()
	{
		$css = '';
		for ($i = 1; $i <= 4096; ++$i) {
			$css .= ".selector-{$i} {display:none}";
		}

		$splitter = new Splitter();
		self::assertEquals('.selector-4096 {display:none}', $splitter->split($css, 2));
	}

	/**
	 * @dataProvider provideSplitFilesAndExpectedResults
	 */
	public function testSplit($expected, $file, $part, $size)
	{
		$splitter = new Splitter();
		self::assertEquals(file_get_contents($expected), $splitter->split(file_get_contents($file), $part, $size));
	}

	/**
	 * make this its own set of tests
	 */
	public function testCountSplit()
	{
		$css = '';
		for ($i = 1; $i <= 4096; ++$i) {
			$css .= ".selector-{$i} {display:none}";
		}

		$css1 = "
		.selector-1 { display:none }
		@media only screen {
			.selector-2,.selector-3 { display:none }
		}
		.selector-4 { display:none }
		@media only screen {
			.selector-4 { display:block }
		}
		.selector-5 { display:none }
		";
		$css = "
		.selector-1 { display:none }
		.selector-2,.selector-3 { display:none }
		.selector-4 { display:none }
		.selector-4 { display:block }
		.selector-5 { display:none }
		";

		$splitter = new Splitter();
		self::assertEquals('.selector-2,.selector-3 { display:none }', $splitter->split($css, 2, 2));
		self::assertEquals('.selector-4 { display:none }.selector-4 { display:block }', $splitter->split($css, 3, 2));
	}
}