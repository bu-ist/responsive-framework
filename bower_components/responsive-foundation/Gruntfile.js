module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		browserSync: {
			docs: {
				bsFiles: {
					src : ['docs/*.html', 'docs/css/*.css', 'docs/js/*.js']
				},
				options: {
					watchTask: true,
					server: {
						baseDir: "./docs"
					}
				}
			}
		},
		concat: {
			docs: {
				files: {
					'docs/js/docs.js': 'js-dev/*.js'
				}
			}
		},
		copy: {
			docs: {
				expand: true,
				cwd: '_docs',
				src: ['**/*.html', 'vendor/**/*'],
				dest: 'docs'
			}
		},
		'gh-pages': {
			options: {
				base: 'docs'
			},
			src: ['**']
		},
		sass: {
			docs: {
				options: {
					style: 'compressed',
					loadPath: 'css-dev'
				},
				files: {
					'docs/css/docs.css': '_docs/css-dev/docs.scss',
				}
			}
		},
		version: {
			bower: {
				src: ['bower.json']
			}
		},
		watch: {
			grunt: {
				options: {
					reload: true
				},
				files: ['Gruntfile.js']
			},
			docs: {
				files: ['_docs/**/*.html'],
				tasks: ['copy']
			},
			scripts: {
				files: [
					'js-dev/*.js'
				],
				tasks: ['concat']
			},
			styles: {
				files: [
					'_docs/css-dev/*.scss',
					'css-dev/**/*.scss'
				],
				tasks: ['sass']
			},
			vendor: {
				files: ['_docs/vendor/**/*'],
				tasks: ['copy']
			}
		}
	});

	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-gh-pages');
	grunt.loadNpmTasks('grunt-version');

	grunt.registerTask('build', ['sass', 'concat', 'copy']);
	grunt.registerTask('deploy', ['build', 'gh-pages']);
	grunt.registerTask('serve', ['build', 'browserSync', 'watch']);

	grunt.registerTask('default', ['serve']);

};
