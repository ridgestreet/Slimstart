module.exports = function(grunt) {
  // Your grunt code goes in here.
  grunt.initConfig({
    lint: {
      files: [
        'www/js/vendors/jquery.1.7.1.js',
        'www/js/vendors/mustache.js',
        'www/js/ridge.js'
      ]
    },
    concat: {
      dist: {
        src: '<config:lint.files>',
        dest: 'www/js/dist/slim.js',
        separator: ';'
      }
    },
    min: {
      dist: {
        src: ['www/js/dist/slim.js'],
        dest: 'www/js/dist/slim.min.js'
      }
    },
    watch: {
      files: '<config:lint.files>',
      tasks: 'concat:dist min:dist'
    }
  });
  
};