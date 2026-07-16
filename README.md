PHP Css Splitter
================

![Tests](https://github.com/dlundgren/php-css-splitter/actions/workflows/tests.yml/badge.svg?event=push)

Splits stylesheets that go beyond the IE limit of 4096 selectors. See this [MSDN blog post](https://learn.microsoft.com/en-us/archive/blogs/ieinternals/stylesheet-limits-in-internet-explorer) for more information about this.

## Installation

It's recommended to use [Composer](https://getcomposer.org) to install

```bash
$ composer require dlundgren/php-css-splitter
```

This will install the CssSplitter library and any required dependencies.

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

CssSplitter is licensed under the MIT license. See [License File](LICENSE) for more information.
