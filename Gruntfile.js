module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        
        // 2. All functions go here.
        watch: {
        	configFiles: {
				files: [ 'Gruntfile.js'],
				options: {
					reload: true
				}
			},
		    scripts: {
		        files: ['js-dev/*.js'],
		        tasks: ['concat', 'uglify'],
		        options: {
		            spawn: false,
		        },
		    },
		    css: {
			    files: ['css-dev/*.scss'],
			    tasks: ['sass'],
			    options: {
			        spawn: false,
			    }
			}
		},
        concat: {
            dist: {
		        src: [
		            'js-dev/libs/*.js', // All JS in the libs folder
		            'js-dev/script.js'  // This specific file
		        ],
		        dest: 'js/production.js',
		    }
        },
        uglify: {
			build: {
				src: 'js/production.js',
				dest: 'js/production.min.js'
			}
		},
		sass: {
		    dist: {
		        options: {
		            style: 'compressed',
		            sourcemap: true
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
    grunt.registerTask('default', ['watch', 'concat', 'uglify']);

};
