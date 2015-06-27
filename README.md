# Responsive Framework

A responsive WordPress theme framework. Uses the [Responsive Foundation](https://github.com/bu-ist/responsive-foundation/).

## Development Requirements

* [Node](http://nodejs.org/) and [Node Package Manager](https://github.com/npm/npm)
* [Grunt](http://gruntjs.com/)
* [Bower](http://bower.io/)

## Quick Start

These instructions assume that you have installed Node and Node Package Manager, and that you have globally installed Grunt and Bower.

1. Clone this repository.
2. Run `npm install` and `bower install` to pull down development dependencies.
3. Run `grunt` to watch your files as you work.

Be sure to commit changes to the generated output files (`style.css`, `js/script.js`, etc.) along with changes to source files!

## Composer Dependencies

The Customizer color and font palettes generate inline styles that are minified using [CSSTidy](https://github.com/Cerdic/CSSTidy) (the same tool used by BU Custom CSS). CSSTidy is installed into the `/vendor/` directory as a dependency using [Composer](https://getcomposer.org).

To upgrade CSSTidy:
1. Install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
2. Edit the [package version](https://getcomposer.org/doc/01-basic-usage.md#package-versions) in `composer.json` and [run `composer install`](https://getcomposer.org/doc/03-cli.md#install) or [run `composer require`](https://getcomposer.org/doc/03-cli.md#require)
3. Commit updates to the `/vendor/` directory
