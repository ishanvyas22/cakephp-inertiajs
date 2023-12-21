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
    # Generate vue scaffolding. You can also use (react) here.
    bin/cake asset_mix generate inertia-vue

    # Install javascript tooling and dependencies.
    npm install
    ```

    **Note:** In order to use Inertia.js, you will need one of [Client-side adapters](ClientSideSetup.md).

4. Just add below line into your layout(`Template/Layout/default.ctp`) file

    ```php
    echo $this->AssetMix->script('app');
    ```

    Your layout file should look something like this:

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

Now you are all set to start using your front-end components as template files. All content will be render between `<body>` tag.

**Note:** If you've created fresh CakePHP project, you must have to create `Display.vue` component into `assets/js/Pages/Pages` directory. See [this](ClientSideSetup.md) link for more info.

## Version map

Plugin version | Branch | CakePHP version | PHP minimum version |
--- | --- | --- | --- |
3.x | cake5 | >=5.0.0 | >=8.1 |
2.x | cake4 | >=4.0.0 | >=7.2 |
1.x | cake3 | >=3.5.0 | >=5.6 |

---

[< Index](README.md) | [Usage >](ServerSideSetup.md)
