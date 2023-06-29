const mix = require('laravel-mix');

mix.webpackConfig({
   resolve: {
      extensions: ['.js', '.vue', '.json'],
      alias: {
         '@': __dirname + '/resources/js',
      },
   },
});
