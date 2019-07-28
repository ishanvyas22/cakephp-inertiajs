const mix = require('laravel-mix');
const path = require('path');

mix
  .js('webroot/js/app.js', 'js/dist')
  .webpackConfig({
    output: {
      path: path.resolve(__dirname, 'webroot'),
      publicPath: '/inertia_cake/',
      chunkFilename: 'js/dist/[name].js?id=[chunkhash]'
    },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@': path.resolve('webroot/js'),
      },
    },
  })
  .babelConfig({
    plugins: ['@babel/plugin-syntax-dynamic-import'],
  })
  .version()
  .sourceMaps();
