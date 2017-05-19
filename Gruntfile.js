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
				src: ['**/*.js', '!**/*.min.js'],
				dest: 'js/vendor',
				ext: '.min.js'
			}
		},
		sass: {
			options: {
				style: 'compressed',
				loadPath: [
					'bower_components/normalize.scss/sass',
					'bower_components/mathsass/dist/',
					'bower_components/responsive-foundation/css-dev'
				],
				bundleExec: true
			},
			dev: {
				options: {
					style: 'expanded'
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
					style: 'expanded',
					sourcemap: 'none'
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
			}
		},
		copy: {
			hooks: {
				options: {
					mode: true
				},
				src: 'hooks/post-merge',
				dest: '.git/hooks/post-merge'
			}
		},
		bower: {
			install: {
				options: {
					targetDir: 'bower_components'
				}
			}
 		},
		modernizr_builder: {
			build: {
				options: {
					config: 'modernizr-config.json',
					dest: 'js/vendor/modernizr.js'
				}
			}
		}
	});

	// 3. Where we tell Grunt we plan to use this plug-in.
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-version');
	grunt.loadNpmTasks( 'grunt-bower-task' );
	grunt.loadNpmTasks( 'grunt-modernizr-builder' );

	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask('install', ['copy:hooks', 'build']);
	grunt.registerTask('default', ['bower:install', 'watch']);
	grunt.registerTask( 'build', ['bower:install', 'modernizr_builder', 'sass', 'concat', 'uglify'] );

};
