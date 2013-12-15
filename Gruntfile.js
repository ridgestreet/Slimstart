module.exports = function(grunt) {
  // Your grunt code goes in here.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    lint: {
      files: [
        'www/js/vendors/jquery.1.7.1.js',
        'www/js/vendors/mustache.js',
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
      files: ['<%= lint.files %>'],
      tasks: ['concat', 'uglify']
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

  grunt.registerTask('default', ['concat']);
  
};