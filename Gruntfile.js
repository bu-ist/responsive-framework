module.exports = function( grunt ) {
	// Report execution time data.
	require( 'time-grunt' )( grunt );

	// Require external packages.
	const autoprefixer = require( 'autoprefixer' );
	const sass = require( 'node-sass' );

	// 1. All configuration goes here
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		// 2. All functions go here.
		watch: {
			grunt: {
				files: [ 'Gruntfile.js' ],
				options: {
					reload: true,
				},
			},
			scripts: {
				files: [
					//'node_modules/responsive-foundation/js-dev/*.js',
					'js-dev/**/*.js',
					'js/vendor/**/*.js',
				],
				tasks: [ 'scripts' ],
				options: {
					spawn: false,
				},
			},
			styles: {
				files: [
					'node_modules/responsive-foundation/css-dev/**/*.scss',
					'!css-dev/customizer/**/*.scss',
					'!css-dev/customizer/**/**/*.scss',
					'!css-dev/admin.scss',
					'css-dev/*.scss',
				],
				tasks: [ 'sass:dev', 'sass:prod' ],
				options: {
					spawn: false,
				},
			},
			fonts: {
				files: [ 'css-dev/customizer/font-palettes/**/*.scss' ],
				tasks: [ 'sass:fonts' ],
				options: {
					spawn: false,
				},
			},
			colors: {
				files: [
					'css-dev/customizer/color-palettes/*.scss'
				],
				tasks: ['sass:colors'],
				options: {
					spawn: false
				}
			},
			admin: {
				files: [ 'css-dev/admin.scss' ],
				tasks: [ 'sass:admin' ],
				options: {
					spawn: false,
				},
			}
		},
		browserify: {
			options: {
				watch: true,
				browserifyOptions: {
					debug: false,
					transform: [ [ 'babelify' ] ],
				},
			},
			dist: {
				files: [
					{
						expand: true, // Enable dynamic expansion.
						cwd: 'js-dev/', // Src matches are relative to this path.
						src: [ '*.js' ], // Actual pattern(s) to match. Targets root JS files.
						dest: 'js/', // Destination path prefix.
					},
				],
			},
		},
		uglify: {
			scripts: {
				options: {
					sourceMap: true,
				},
				// Note: Overwrites the un-uglified version.
				expand: true,
				cwd: 'js/',
				src: [ '*.js' ],
				dest: 'js/',
			},
			vendor: {
				options: {
					sourceMap: true,
				},
				expand: true,
				cwd: 'js/vendor',
				src: [ '*.js', '!*.min.js' ],
				dest: 'js/vendor',
			},
		},
		sass: {
			options: {
				outputStyle: 'compressed',
				implementation: sass,
				sourceMap: true,
				indentType: 'space',
				indentWidth: 2,
				precision: '5',
				includePaths: [
					'node_modules/normalize-scss/sass',
					'node_modules/mathsass/dist/',
					'node_modules/responsive-foundation/css-dev',
				],
				bundleExec: true,
			},
			dev: {
				options: {
					outputStyle: 'expanded',
				},
				files: {
					'style.css': 'css-dev/style.scss',
					'ie.css': 'css-dev/ie.scss',
				},
			},
			prod: {
				files: {
					'style.min.css': 'css-dev/style.scss',
					'ie.min.css': 'css-dev/ie.scss',
				},
			},
			fonts: {
				options: {
					outputStyle: 'expanded',
					sourceMap: false,
				},
				files: [
					{
						expand: true,
						cwd: 'css-dev/customizer/font-palettes',
						src: [ '*.scss' ],
						dest: 'css',
						ext: '.css',
					},
				],
			},
			colors: {
				options: {
					outputStyle: 'expanded',
					sourceMap: false
				},
				files: [{
					expand: true,
					cwd: 'css-dev/customizer/color-palettes',
					src: ['*.scss'],
					dest: 'css',
					ext: '.css'
				}]
			},
			admin: {
				files: [
					{
						'admin/admin.css': 'css-dev/admin.scss',
					},
				],
			},
		},
		postcss: {
			defaults: {
				options: {
					map: {
						inline: false, // Save all sourcemaps as separate files.
					},
					processors: [
						autoprefixer, // add vendor prefixes.
					],
				},
				src: ['style.css', 'style.min.css'],
			},
			admin: {
				options: {
					map: {
						inline: false, // Save all sourcemaps as separate files.
						annotation: 'admin/', // Save to this specified directory.
					},
					processors: [
						autoprefixer, // add vendor prefixes.
					],
				},
				src: ['admin/admin.css'],
			},
		},
		addtextdomain: {
			options: {
				textdomain: 'responsive-framework',
				updateDomains: true,
			},
			target: {
				files: {
					src: [
						'*.php',
						'**/*.php',
						'!bin/**',
						'!node_modules/**',
						'!node_modules/**',
						'!tests/**',
						'!vendor/**',
					],
				},
			},
		},
		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					potFilename: 'responsive-framework.pot',
					mainFile: 'functions.php',
					potHeaders: {
						poedit: true,
						language: 'en',
						'x-poedit-country': 'United States',
						'x-poedit-keywordslist': true,
						'x-poedit-sourcecharset': 'UTF-8',
						'x-textdomain-support': 'yes',
					},
					type: 'wp-theme',
					updateTimestamp: false,
				},
			},
		},
		version: {
			functions: {
				options: {
					prefix: "['\"]RESPONSIVE_FRAMEWORK_VERSION['\"],\\s*'",
				},
				src: [ 'functions.php' ],
			},
			styles: {
				options: {
					prefix: 'Version:\\s*',
				},
				src: [ 'css-dev/style.scss' ],
			},
			/*modernizr: {
				options: {
					pkg: 'node_modules/modernizr/package.json',
					prefix: "['\"]RESPONSIVE_MODERNIZR_VERSION['\"],\\s*'",
				},
				src: [ 'functions.php' ],
			},*/
			lightgallery: {
				options: {
					pkg: 'node_modules/lightgallery/package.json',
					prefix: "['\"]RESPONSIVE_LIGHTGALLERY_VERSION['\"],\\s*'",
				},
				src: [ 'functions.php' ],
			},
			lg_thumbnail: {
				options: {
					pkg: 'node_modules/lg-thumbnail/package.json',
					prefix: "['\"]RESPONSIVE_LG_THUMBNAIL_VERSION['\"],\\s*'",
				},
				src: [ 'functions.php' ],
			},
		},
		copy: {
			hooks: {
				options: {
					mode: true,
				},
				src: 'hooks/post-merge',
				dest: '.git/hooks/post-merge',
			},
			lightgallery: {
				options: {
					mode: true,
				},
				expand: true,
				cwd: 'node_modules/lightgallery/',
				src: [ 'fonts/**/*', 'images/**/*', 'css/**/*' ],
				dest: 'js/vendor/lightgallery/',
			},
		},
		modernizr: {
			dist: {
				parseFiles: false,
				dest: 'js/vendor/modernizr.js',
				tests: [
					'audio',
					'backgroundsize',
					'borderimage',
					'borderradius',
					'boxshadow',
					'canvas',
					'canvastext',
					'cssanimations',
					'csscolumns',
					'cssgradients',
					'csspositionsticky',
					'cssreflections',
					'csstransforms',
					'csstransforms3d',
					'csstransitions',
					'flexbox',
					'flexboxlegacy',
					'fontface',
					'geolocation',
					'generatedcontent',
					'hashchange',
					'hsla',
					'inlinesvg',
					'localstorage',
					'multiplebgs',
					'objectfit',
					'opacity',
					'picture',
					'postmessage',
					'requestanimationframe',
					'rgba',
					'smil',
					'svg',
					'svgclippaths',
					'textshadow',
					'video',
					'videoautoplay',
					'webgl',
				],
				options: [
					'domPrefixes',
					'hasEvent',
					'html5printshiv',
					'prefixed',
					'prefixes',
					'setClasses',
					'testAllProps',
					'testProp',
					'testStyles',
				],
				uglify: false,
			},
		},
		clean: {
			languages: [ 'languages/*' ],
			js: [ 'js/**/*.js', 'js/**/*.map', '!js/vendor/**/*' ],
		},
	} );

	// 3. Where we tell Grunt we plan to use this plug-in.
	grunt.loadNpmTasks( 'grunt-browserify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-notify' );
	grunt.loadNpmTasks( 'grunt-version' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-modernizr' );

	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask( 'install', [ 'copy', 'build' ] );
	grunt.registerTask( 'i18n', [ 'clean:languages', 'addtextdomain', 'makepot' ] );
	grunt.registerTask( 'styles', [ 'sass', 'postcss' ] );
	grunt.registerTask( 'scripts', [ 'clean:js', 'browserify', 'uglify' ] );
	grunt.registerTask( 'update_lightgallery', [
		'copy:lightgallery',
		'version:lightgallery',
		'version:lg_thumbnail',
	] );
	grunt.registerTask( 'upgrade_modernizr', [
		'modernizr:dist',
		'uglify',
		'version:modernizr',
	] );
	grunt.registerTask( 'build', [ 'styles', 'scripts', 'i18n' ] );
	grunt.registerTask( 'default', [ 'watch' ] );
};
