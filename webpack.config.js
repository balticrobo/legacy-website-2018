const Encore = require('@symfony/webpack-encore');

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .cleanupOutputBeforeBuild()
  .enableSassLoader()
  .enablePostCssLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning()
  .autoProvideVariables({
    $: 'jquery',
    jQuery: 'jquery',
    'window.jQuery': 'jquery'
  })
  .createSharedEntry('js/common', [
    'jquery',
    'popper.js/dist/popper.js',
    'tether',
    'bootstrap/js/dist/util',
    'bootstrap/js/dist/alert',
    'bootstrap/js/dist/button',
    'bootstrap/js/dist/carousel',
    'bootstrap/js/dist/collapse',
    'bootstrap/js/dist/dropdown',
    'bootstrap/js/dist/modal',
    'bootstrap/js/dist/scrollspy',
    'bootstrap/js/dist/tab',
    'bootstrap/js/dist/tooltip',
    'bootstrap/js/dist/popover'
  ])
  .addEntry('js/app', './assets/js/app.js')
  .addStyleEntry('css/app', './assets/scss/main.scss');

module.exports = Encore.getWebpackConfig();
