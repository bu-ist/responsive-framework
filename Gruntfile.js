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
					spawn: false,
				},
			},
			styles: {
				files: [
				'bower_components/responsive-foundation/css-dev/**/*.scss',
				'!bower_components/responsive-foundation/css-dev/customizer/**/*.scss',
				'css-dev/*.scss'
				],
				tasks: ['sass:dev', 'sass:prod'],
				options: {
					spawn: false,
				}
			},
			fonts: {
				files: [
				'bower_components/responsive-foundation/css-dev/customizer/font-palettes/*.scss',
				],
				tasks: ['sass:fonts'],
				options: {
					spawn: false,
				}
			}
		},
		concat: {
			scripts: {
				src: [
					'bower_components/responsive-foundation/js-dev/*.js',
					'js-dev/*.js'
				],
				dest: 'js/script.js',
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
			dev: {
				options: {
					style: 'expanded',
					loadPath: 'bower_components/responsive-foundation/css-dev',
					bundleExec: true
				},
				files: {
					'style.css': 'css-dev/style.scss',
					'ie.css': 'css-dev/ie.scss'
				}
			},
			prod: {
				options: {
					style: 'compressed',
					loadPath: 'bower_components/responsive-foundation/css-dev',
					bundleExec: true
				},
				files: {
					'style.min.css': 'css-dev/style.scss',
					'ie.min.css': 'css-dev/ie.scss'
				}
			},
			fonts: {
				options: {
					style: 'compressed',
					sourcemap: 'none'
				},
				files: [{
					expand: true,
					cwd: 'bower_components/responsive-foundation/css-dev/customizer/font-palettes',
					src: ['*.scss'],
					dest: 'css',
					ext: '.css'
				}]
			}
		},
		version: {
			bower: {
				src: ['bower.json']
			},
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

	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask('build', ['sass', 'concat', 'uglify']);
	grunt.registerTask('default', ['watch']);

};
