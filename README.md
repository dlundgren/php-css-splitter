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
$count = $splitter->countSelectors($css)  - 4095;
if ($count > 0) {
    $part = 2;
    for($i = $count; $i > 0; $i -= 4095) {
        file_put_contents("styles-split{$part}.css", $splitter->split($css, 2));
    }
}


```
## Credits & License

Original inspiration came from the Ruby gem [CssSplitter](https://github.com/zweilove/css_splitter).

Uses the MIT license.
