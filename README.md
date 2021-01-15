# WP-Console

A simple package to log php to the browser console in WordPress plugins and themes. Simply include the package, preferrebly through composer, and go about logging errors, strings, objects arrays...whatever you need to visualize. It's meant as an alternative to var_dump, and works with Ajax requests.

## Installation

Simply add a dependency on wpcl/wpconsole to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```
composer require wpcl/wpconsole
```
Although it's recommended to use Composer, you can actually anyway you want.

## Usage
```
use wpcl\wpconsole\Console;

$error1 = 'Anything you want to log';

Console::log( $error1 );

$error2 = ['Some Item', 'Some Other Item'];

Console::log( $error2 );
```
