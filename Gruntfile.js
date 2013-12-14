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
        src: '<%= lint.files %>',
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
      files: ['<%= lint.files %>'],
      tasks: ['concat']
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