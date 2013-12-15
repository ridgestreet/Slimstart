module.exports = function(grunt) {
  // Your grunt code goes in here.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    coffee: {
      dist: {
        files: [{
          expand: true,
          cwd: 'www/coffee',
          src: ['{,*/}*.coffee'],
          dest: 'www/js/src',
          rename: function(dest, src) {
            return dest + '/' + src.replace(/\.coffee$/, '.js');
          }
        }]
      }
    },
    lint: {
      files: [
        'www/js/vendors/mustache.js',
        'www/js/src/**/*.js',
        'www/js/ridge.js'
      ]
    },
    concat: {
      dist: {
        src: '<%= lint.files %>',
        dest: 'www/js/dist/<%= pkg.name %>.js',
        separator: ';'
      }
    },
    min: {
      dist: {
        src: ['www/js/dist/<%= pkg.name %>.js'],
        dest: 'www/js/dist/<%= pkg.name %>.min.js'
      }
    },
    watch: {
      scripts: {
        files: ['<%= lint.files %>'],
        tasks: ['concat', 'uglify']
      },
      coffee: {
        files: ['www/coffee/*.coffee'],
        tasks: ['coffee']
      }
      
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-dd-mm") %> */\n'
      },
      dist: {
        files: {
          'www/js/dist/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
        }
      }
    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-sass');

  grunt.registerTask('default', ['concat', 'uglify', 'watch']);
  
};