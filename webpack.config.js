const Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .cleanupOutputBeforeBuild()
  .splitEntryChunks()
  .enableSingleRuntimeChunk()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabel(() => {}, {
    useBuiltIns: 'usage',
    corejs: 3,
  })
  .enableSassLoader()
  .autoProvidejQuery()
  .addEntry('app', './assets/js/app.js')
  .addEntry('admin', './assets/js/admin.js')
  .copyFiles({
    from: './assets/img',
    to: 'images/[path][name].[hash:8].[ext]',
 })
;

module.exports = Encore.getWebpackConfig();
