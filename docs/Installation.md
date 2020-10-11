# Installation

1. Add this plugin to your application with [composer](https://getcomposer.org)

    ```bash
    composer require ishanvyas22/cakephp-inertiajs
    ```

2. Load plugin into your application

    ```bash
    bin/cake plugin load Inertia
    ```

3. Generate Client-side scaffolding (Inertia.js + Vue.js)

    ```bash
    bin/cake asset_mix generate inertia-vue
    ```

    **Note:** In order to use Inertia.js, you will need any one of [Client-side adapters](https://inertiajs.com/client-side-setup). This plugin leverages [AssetMix plugin](https://github.com/ishanvyas22/asset-mix/tree/cake3) so you don't have to install all the front-end dependencies one by one. Instead you can directly generate scaffolding(using above command) to quickly get started.

4. Just add below line into your layout(`Template/Layout/default.ctp`) file

    ```php
    echo $this->AssetMix->script('app');
    ```

    So your layout file will look something like this:

    ```php
    <!DOCTYPE html>
    <html>
        <head>
            <?= $this->Html->charset() ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
            <?= $this->Html->meta('icon') ?>

            // Add title, load your css, etc.
            // ...

            // Load `app.js` javascript file
            <?= $this->AssetMix->script('app') ?>

            <?= $this->fetch('meta') ?>
            <?= $this->fetch('css') ?>
            <?= $this->fetch('script') ?>
        </head>
        <body>
            <?= $this->fetch('content') ?>
        </body>
    </html>
    ```

    Now you are all set to start using your front end components as template files. All content will be render between `<body>` tag.

[< Go Back](README.md) | [Usage >](Usage.md)
