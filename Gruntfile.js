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
				'css-dev/*.scss'
				],
				tasks: ['sass'],
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
				dest: 'js/production.js',
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
			styles: {
				options: {
					style: 'compressed',
					sourcemap: true,
					loadPath: 'bower_components/responsive-foundation/css-dev'
				},
				files: {
					'style.css': 'css-dev/style.scss',
					'ie.css': 'css-dev/ie.scss'
				}
			}
		}

	});

	// 3. Where we tell Grunt we plan to use this plug-in.
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');


	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask('build', ['sass', 'concat', 'uglify']);
	grunt.registerTask('default', ['watch']);

};