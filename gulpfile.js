var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('styles.scss', elixir.config.cssInput)
	    .copy(elixir.config.bowerDir +'normalize-css/normalize.css', 
		      elixir.config.cssInput)
		.copy(elixir.config.bowerDir + 'emojify.js/dist/css/basic/emojify.css',
			  elixir.config.cssInput)
        .styles([
            'normalize.css',
            'styles.css',
			'emojify.css'
        ], 'public/css/all.css')
		.copy(elixir.config.bowerDir + 'jquery/dist/jquery.js',
			  elixir.config.jsInput)
		.copy(elixir.config.bowerDir + 'jQuery-linkify/dist/jquery.linkify.js',
			  elixir.config.jsInput)
		.copy(elixir.config.bowerDir + 'jquery-waypoints/lib/jquery.waypoints.js',
			  elixir.config.jsInput)
		.copy(elixir.config.bowerDir + 'emojify.js/dist/js/emojify.js',
			  elixir.config.jsInput)
        .scripts([
            'jquery.js',
            'jquery.waypoints.js',
            'jquery.linkify.js',
			'emojify.js',
            'scripts.js',
            'infinite-scrolling.js'	
        ], 'public/js/all.js')
		.copy(elixir.config.bowerDir + 'emojify.js/dist/images/basic/',
			  'public/img/basic');
});
