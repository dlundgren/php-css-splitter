PHP Css Splitter
================

[![Build Status](https://travis-ci.org/dlundgren/php-css-splitter.svg?branch=master)](https://travis-ci.org/dlundgren/php-css-splitter)

Splits stylesheets that go beyond the IE limit of 4096 selectors. See this [MSDN blog post](http://blogs.msdn.com/b/ieinternals/archive/2011/05/14/internet-explorer-stylesheet-rule-selector-import-sheet-limit-maximum.aspx) for more information about this.

## Installation

Use composer

## Usage

The default max selectors is 4095.

```php

$splitter = new \CssSplitter\Splitter();
// Load your css file
$css = file_get_contents('styles.css');

// Skip the first part as the Internet Explorer interprets your css until it reaches the limit
$selector_count = $splitter->countSelectors($css) - 4095;
// Calculate how many additional parts we need to create
$additional_part_count =  ceil($selector_count / 4095);

if($additional_part_count > 0) {
	// Loop and create the additional parts
	// Add an offset of two as we are creating the css from the second part on
	for($part = 2; $part < $additional_part_count + 2; $part++) {
		// Create or update the css files
		file_put_contents('styles_'. $part .'.css', $splitter->split($css, $part));
	}
}


```
## Credits & License

Original inspiration came from the Ruby gem [CssSplitter](https://github.com/zweilove/css_splitter).

Uses the MIT license.
