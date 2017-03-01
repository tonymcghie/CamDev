/**
 * Created by mgoo on 1/03/17.
 */
module.exports = function(grunt) {
    grunt.initConfig({
        jshint: {
            files: ['app/webroot/js/**.js', '!app/webroot/js/typescript/**.js', '!app/webroot/js/lib/**.js', '!app/webroot/js/JsPlugins/**.js'],
            options: {
                globals: {
                    jQuery: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
};