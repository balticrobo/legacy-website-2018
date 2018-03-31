const Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .cleanupOutputBeforeBuild()
  .enableSassLoader()
  .enablePostCssLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning()
  .autoProvidejQuery()
  .autoProvideVariables({
    Popper: 'popper.js',
    Tether: 'tether',
    Util: "exports-loader?Util!bootstrap/js/dist/util",
    Alert: "exports-loader?Alert!bootstrap/js/dist/alert",
    Button: "exports-loader?Button!bootstrap/js/dist/button",
    //Carousel: "exports-loader?Carousel!bootstrap/js/dist/carousel",
    Collapse: "exports-loader?Collapse!bootstrap/js/dist/collapse",
    Dropdown: "exports-loader?Dropdown!bootstrap/js/dist/dropdown",
    Modal: "exports-loader?Modal!bootstrap/js/dist/modal",
    Scrollspy: "exports-loader?Scrollspy!bootstrap/js/dist/scrollspy",
    Tab: "exports-loader?Tab!bootstrap/js/dist/tab",
    Tooltip: "exports-loader?Tooltip!bootstrap/js/dist/tooltip",
    Popover: "exports-loader?Popover!bootstrap/js/dist/popover",

  })
  .createSharedEntry('js/common', [
    'jquery',
    'popper.js',
    'tether',
    'bootstrap/js/dist/util',
    'bootstrap/js/dist/alert',
    'bootstrap/js/dist/button',
    //'bootstrap/js/dist/carousel',
    'bootstrap/js/dist/collapse',
    'bootstrap/js/dist/dropdown',
    'bootstrap/js/dist/modal',
    'bootstrap/js/dist/scrollspy',
    'bootstrap/js/dist/tab',
    'bootstrap/js/dist/tooltip',
    'bootstrap/js/dist/popover',
  ])
  .addEntry('js/app', './assets/js/app.js')
  .addStyleEntry('css/app', './assets/scss/main.scss');

module.exports = Encore.getWebpackConfig();
