module.exports = function(grunt) {

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
					outputStyle: 'expanded',
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
					sourceMap: false,
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
					'canvas',
					'canvastext',
					'geolocation',
					'hashchange',
					'postmessage',
					'requestanimationframe',
					'svg',
					'video',
					'webgl',
					'cssanimations',
					'backgroundsize',
					'borderimage',
					'borderradius',
					'boxshadow',
					'csscolumns',
					'flexbox',
					'flexboxlegacy',
					'fontface',
					'generatedcontent',
					'cssgradients',
					'hsla',
					'multiplebgs',
					'opacity',
					'objectfit',
					'cssreflections',
					'rgba',
					'textshadow',
					'csstransforms',
					'csstransforms3d',
					'csstransitions',
					'localstorage',
					'svgclippaths',
					'inlinesvg',
					'smil',
					'videoautoplay'
				],
				'options': [
					'domPrefixes',
					'prefixes',
					'hasEvent',
					'prefixed',
					'testAllProps',
					'testProp',
					'testStyles',
					'html5printshiv',
					'setClasses'
				],
				'uglify': false
			}
		}
	});

	// 3. Where we tell Grunt we plan to use this plug-in.
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-version');
	grunt.loadNpmTasks( 'grunt-bower-task' );
	grunt.loadNpmTasks( 'grunt-modernizr' );

	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask('install', ['copy:hooks', 'build']);
	grunt.registerTask('default', ['bower:install', 'watch']);
	grunt.registerTask( 'update_lightgallery', [ 'copy:lightgallery', 'copy:lgthumbnail' ] );
	grunt.registerTask( 'upgrade_modernizr', [ 'modernizr:dist', 'uglify', 'version:modernizr' ] );
	grunt.registerTask( 'build', ['bower:install', 'sass', 'concat', 'uglify'] );
};
