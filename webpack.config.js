const Encore = require('@symfony/webpack-encore');

Encore
    // Répertoire de sortie des fichiers compilés
    .setOutputPath('public/build/')
    // URL publique des fichiers compilés
    .setPublicPath('/build')

    // Point d'entrée principal (ex. fichier JS de base)
    .addEntry('app', './assets/app.js')

    // Active la prise en charge des fichiers CSS/SCSS
    .enableSingleRuntimeChunk()
    .enableSassLoader()

    // Active la prise en charge des fichiers modernes JS (Babel)
    .enableStimulusBridge('./assets/controllers.json')

    // Copie les fichiers (ex. images) dans le répertoire de sortie
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]'
    })

    // Active les notifications dans le terminal lors de la compilation
    .enableBuildNotifications()

    // Définit le mode (développement ou production)
    .setMode(Encore.isProduction() ? 'production' : 'development')
;

module.exports = Encore.getWebpackConfig();
