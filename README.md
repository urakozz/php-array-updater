PHP Array Updater
=================

[![Build Status](https://travis-ci.org/urakozz/php-array-updater.svg?branch=master)](https://travis-ci.org/urakozz/php-array-updater)
[![Coverage Status](https://img.shields.io/coveralls/urakozz/php-array-updater.svg)](https://coveralls.io/r/urakozz/php-array-updater?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/urakozz/php-array-updater/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/urakozz/php-array-updater/?branch=master)

Recursive Array Updater


```php
  $source = ['this' => ['is' => ['the' => ['path' => [
    1,2,3,4,5
  ]]]]];
  
  $array = ArrayUpdater::from($array)->node('this')->node('is')->node('the')->node('path')->all()->replace(1, 100);
  
  $expected = ['this' => ['is' => ['the' => ['path' => [
    100,2,3,4,5
  ]]]]];

```
