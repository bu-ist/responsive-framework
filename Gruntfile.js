module.exports = function(grunt) {

	// Report execution time data.
	require( 'time-grunt' )(grunt);

	// 1. All configuration goes here
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// 2. All functions go here.
		watch: {
			grunt: {
				files: [ 'Gruntfile.js'],
				options: {
					reload: true
				}
			},
			scripts: {
				files: [
				'bower_components/responsive-foundation/js-dev/*.js',
				'js-dev/*.js',
				'js/vendor/**/*.js'
				],
				tasks: ['concat', 'uglify'],
				options: {
					spawn: false
				}
			},
			styles: {
				files: [
					'bower_components/responsive-foundation/css-dev/**/*.scss',
					'!css-dev/customizer/**/*.scss',
					'!css-dev/admin.scss',
					'css-dev/*.scss'
				],
				tasks: ['sass:dev', 'sass:prod'],
				options: {
					spawn: false
				}
			},
			fonts: {
				files: [
					'css-dev/customizer/font-palettes/*.scss'
				],
				tasks: ['sass:fonts'],
				options: {
					spawn: false
				}
			},
			admin: {
				files: [
					'css-dev/admin.scss'
				],
				tasks: ['sass:admin'],
				options: {
					spawn: false
				}
			},
			phplint : {
				files : [ '**/*.php' ],
				tasks : [ 'phplint' ],
				options : {
					spawn : false
				}
			}
		},
		concat: {
			scripts: {
				src: [
					'bower_components/responsive-foundation/js-dev/*.js',
					'js-dev/*.js'
				],
				dest: 'js/script.js'
			}
		},
		uglify: {
			scripts: {
				expand: true,
				cwd: 'js',
				src: ['*.js', '!*.min.js'],
				dest: 'js',
				ext: '.min.js'
			},
			vendor: {
				expand: true,
				cwd: 'js/vendor',
				src: ['*.js', '!*.min.js'],
				dest: 'js/vendor',
				ext: '.min.js'
			}
		},
		sass: {
			options: {
				outputStyle: 'compressed',
				sourceMap: true,
				indentType: 'space',
				indentWidth: 2,
				precision: '5',
				includePaths: [
					'bower_components/normalize.scss/sass',
					'bower_components/mathsass/dist/',
					'bower_components/responsive-foundation/css-dev'
				],
				bundleExec: true
			},
			dev: {
				options: {
					outputStyle: 'expanded'
				},
				files: {
					'style.css': 'css-dev/style.scss',
					'ie.css': 'css-dev/ie.scss'
				}
			},
			prod: {
				files: {
					'style.min.css': 'css-dev/style.scss',
					'ie.min.css': 'css-dev/ie.scss'
				}
			},
			fonts: {
				options: {
					outputStyle: 'expanded',
					sourceMap: false
				},
				files: [{
					expand: true,
					cwd: 'css-dev/customizer/font-palettes',
					src: ['*.scss'],
					dest: 'css',
					ext: '.css'
				}]
			},
			admin: {
				files: [{
					'admin/admin.css': 'css-dev/admin.scss'
				}]
			}
		},
		addtextdomain: {
			options: {
				textdomain: 'responsive-framework',
				updateDomains: [
					'YOUR-TEXTDOMAIN',
					'cmb2',
					'_s'
				]
			},
			target: {
				files: {
					src: [
						'*.php',
						'**/*.php',
						'!bin/**',
						'!bower_components/**',
						'!node_modules/**',
						'!tests/**',
						'!vendor/**'
					]
				}
			}
		},
		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					potFilename: 'responsive-framework.pot',
					mainFile: 'functions.php',
					potHeaders: {
						poedit: true,
						'language': 'en',
						'x-poedit-country': 'United States',
						'x-poedit-keywordslist': true,
						'x-poedit-sourcecharset': 'UTF-8',
						'x-textdomain-support': 'yes'
					},
					type: 'wp-theme',
					updateTimestamp: false
				}
			}
		},
		version: {
			functions: {
				options: {
					prefix: '[\'"]RESPONSIVE_\\w*_VERSION[\'"],\\s*\''
				},
				src: ['functions.php']
			},
			styles: {
				options: {
					prefix: 'Version:\\s*'
				},
				src: ['css-dev/style.scss']
			},
			modernizr: {
				options: {
					pkg: 'node_modules/modernizr/package.json',
					prefix: '[\'"]RESPONSIVE_MODERNIZR_VERSION[\'"],\\s*\''
				},
				src: ['functions.php']
			}
		},
		copy: {
			hooks: {
				options: {
					mode: true
				},
				src: 'hooks/post-merge',
				dest: '.git/hooks/post-merge'
			},
			lightgallery: {
				options: {
					mode: true
				},
				expand: true,
				cwd: 'node_modules/lightgallery/dist/',
				src: '**',
				dest: 'js/vendor/lightgallery/'
			},
			lgthumbnail: {
				options: {
					mode: true
				},
				expand: true,
				cwd: 'node_modules/lg-thumbnail/dist/',
				src: '**',
				dest: 'js/vendor/lg-thumbnail/'
			}
		},
		phplint: {
			options: {
				phpArgs: {
					'-l': null,
					'-f': null
				}
			},
			all : {
				src : [
					'**/**.php',
					'!vendor/**',
					'!node_modules/**'
				]
			}
		},
		bower: {
			install: {
				options: {
					targetDir: 'bower_components'
				}
			}
 		},
		modernizr: {
			dist: {
				'parseFiles': false,
				'dest': 'js/vendor/modernizr.js',
				'tests': [
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
					'webgl'
				],
				'options': [
					'domPrefixes',
					'hasEvent',
					'html5printshiv',
					'prefixed',
					'prefixes',
					'setClasses',
					'testAllProps',
					'testProp',
					'testStyles'
				],
				'uglify': false
			}
		},
		clean: {
			build: [
				'languages/*'
			]
		}
	});

	// 3. Where we tell Grunt we plan to use this plug-in.
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-notify' );
	grunt.loadNpmTasks( 'grunt-version' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-phplint' );
	grunt.loadNpmTasks( 'grunt-bower-task' );
	grunt.loadNpmTasks( 'grunt-modernizr' );

	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask( 'install',             [ 'copy:hooks', 'bower:install', 'build' ] );
	grunt.registerTask( 'i18n',                [ 'clean', 'addtextdomain', 'makepot' ] );
	grunt.registerTask( 'styles',              [ 'sass' ] );
	grunt.registerTask( 'scripts',             [ 'phplint', 'concat', 'uglify' ] );
	grunt.registerTask( 'update_lightgallery', [ 'copy:lightgallery', 'copy:lgthumbnail' ] );
	grunt.registerTask( 'upgrade_modernizr',   [ 'modernizr:dist', 'uglify', 'version:modernizr' ] );
	grunt.registerTask( 'build',               [ 'bower:install', 'sass', 'scripts', 'i18n' ] );
	grunt.registerTask( 'default',             [ 'bower:install', 'watch' ] );
};
