# Responsive Foundation

This framework provides a library of [Sass](http://sass-lang.com/) and Javascript files that serve as a foundation for building responsive sites. This library is designed to be imported into your project using [Bower](http://bower.io).

It was initially conceived during the build for the WordPress [Responsive Framework](https://github.com/bu-ist/responsive-framework) as a way to share common front-end assets among themes, but does not have an WordPress-specific bindings and can be used for non-WordPress projects as well.

Note that this repository does not include any production-ready assets (e.g. minified, compressed). The build process is entirely up to the project.

## Installation

[Bower](http://bower.io) is the recommended installation method:

```bash
$ npm install -g bower
$ bower install git@github.com:bu-ist/responsive-foundation.git#1.0.0
```

## Sass Usage

The Foundation Sass files are split in to two layers:

* __Base__ - The base layer provides foundational components: CSS reset, responsive grid, and typography.
* __Theme__ - The theme layer adds a more fleshed out visual appearance on top of the base.

Note that the theme layer makes several assumptions about your markup. It's primarily used to generate the main stylesheet for the [Responsive Framework](https://github.com/bu-ist/responsive-framework/) parent theme. If you're working on a child theme that is similar in appearance, you probably want to include both layers.

In your project's main SCSS file:

```sass
# css-dev/style.scss:

// Import base layer
@import "burf-base";

// Import theme layer
@import "burf-theme";
```

These lines assume that the [responsive-foundation/css-dev](css-dev) directory in this repository is included in your [Sass load path](http://sass-lang.com/documentation/file.SASS_REFERENCE.html#load_paths-option). If you followed the install steps above and are using Grunt to manage Sass compilation, your `sass` task configuration might look like:

```javascript
	sass: {
		options: {
			loadPath: "bower_components/responsive-foundation/css-dev"
		},
		files: {
			"style.css": "css-dev/style.scss"
		}
	}
```

Both the base and theme layers support customization with Sass variables.

Full usage documentation can be found in the [visual style guide](https://bu-ist.github.io/responsive-foundation/).
