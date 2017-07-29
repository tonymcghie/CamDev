/**
 * Created by mgoo on 1/03/17.
 */
module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);

    var uglifyRename = function(destPath, srcPath) {
        if (srcPath.includes('.es5.')) {
            destPath = srcPath.replace('.es5.', '.min.');
        } else {
            destPath = srcPath.replace('.js', '.min.js');
        }
        return destPath;
    };
    var babelRename = function(destPath, srcPath) {
        destPath = srcPath.replace('.js', '.es5.js');
        return destPath;
    };
    var tsRename = function(destPath, srcPath) {
        destPath = srcPath.replace('.ts', '.js');
        return destPath;
    };

    grunt.initConfig({
        jshint: {
            files: ['app/webroot/js/**.js', '!app/webroot/js/**.min.js', '!app/webroot/js/**.es5.js', '!app/webroot/js/typescript/**.js', '!app/webroot/js/lib/**.js', '!app/webroot/js/JsPlugins/**.js'],
            options: {
                globals: {
                    jQuery: true
                },
                esversion: 6
            }
        },
        uglify: {
            files:{
                src: ['app/webroot/js/**.es5.js',
                    'app/webroot/js/typescript/**.js',
                    'app/webroot/js/typescript/**/**.js',
                    '!app/webroot/js/typescript/**.min.js',
                    '!app/webroot/js/typescript/**/**.min.js',
                    '!app/webroot/js/**.min.js',
                    '!app/webroot/js/**.es5.js.map',
                    '!app/webroot/js/lib/**.js',
                    '!app/webroot/js/JsPlugins/**.js'],
                expand: true,
                rename: uglifyRename
            },
            options: {report: 'none'}
        },
        less: {
            development: {
                options: {
                    strictMath: true,
                    paths: ['app/webroot/css/less'],
                    compress: true
                },
                files: {
                    'app/webroot/css/styles_required.css': 'app/webroot/css/less/styles_required.less',
                    'app/webroot/css/styles_content.css': 'app/webroot/css/less/styles_content.less'
                }
            }
        },
        babel: {
            options: {
                sourceMap: true,
                presets: ['babel-preset-es2015']
            },
            files: {
                src: ['app/webroot/js/**.js', '!app/webroot/js/**.min.js', '!app/webroot/js/**.es5.js', '!app/webroot/js/**.es5.js.map', '!app/webroot/js/typescript/**.js', '!app/webroot/js/lib/**.js', '!app/webroot/js/JsPlugins/**.js'],
                expand: true,
                rename: babelRename
            }
        },
        clean: {
            files: ['app/webroot/js/**.es5.js*']
        },
        ts: { /*currently not working */
            options: {
                target: 'es5'
            },
            dev: {
                src: ['app/webroot/js/typescript/**.ts'],
                expand: true
            }

        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-babel');
    grunt.loadNpmTasks('grunt-ts');
    grunt.registerTask('default', ['ts', 'jshint', 'uglify', 'babel', 'less']);
    grunt.registerTask('js', ['jshint', 'babel', 'uglify', 'clean']);

};