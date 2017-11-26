const Encore  = require('@symfony/webpack-encore');
const path    = require('path');

const assets_path   = path.resolve('./src/AppBundle/Resources/private');
const output_path   = (Encore.isProduction()) ? path.resolve('./src/AppBundle/Resources/public') : path.resolve('./src/AppBundle/Resources/public');
const public_path   = (Encore.isProduction()) ? '/bundles/app' : '/public';
const sass_path     = path.join(assets_path, './sass');
const js_path       = path.join(assets_path, './js');

Encore
    // empty the outputPath dir before each build
    // .cleanupOutputBeforeBuild()

    // directory where all compiled assets will be stored
    .setOutputPath(output_path)

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath(public_path)

    // will output as web/build/app.js
    .addEntry('app', path.join(js_path, '/app.js'))

    // will output as web/build/global.css
    .addStyleEntry('style', path.join(sass_path, '/style.scss'))

    // allow sass/scss files to be processed
    .enableSassLoader()
    .enablePostCssLoader()

    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(false)

    .setManifestKeyPrefix('bundles/app');


var config = Encore.getWebpackConfig();
config.watchOptions = { poll: true, ignored: /node_modules/ };

if (config.devServer) {
    config.devServer.watchContentBase = true;
}

// export the final configuration
module.exports = config;