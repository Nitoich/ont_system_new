const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/Apps/TeacherManage/app.js', 'public/js/teacher_manage.js')
    .js('resources/js/Apps/Home/app.js', 'public/js/home.js')
    .vue()
    .postCss('resources/css/app.css', 'public/css/app.css', [require('tailwindcss')])
