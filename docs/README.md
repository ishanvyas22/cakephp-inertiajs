## Installation

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

## Usage

## Server-side Setup

To start using Inertia.js into your app, you just have to add `Inertia\Controller\InertiaResponseTrait` into your `AppController.php` controller. And it will automatically render the response according to the request.

```php
<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Inertia\Controller\InertiaResponseTrait;

class AppController extends Controller
{
    use InertiaResponseTrait;

    // ...
}
```

`InertiaResponseTrait` will handle all the heavy lifting that is needed render your views and components. As you can see in above example, you just have to set the variables(same as you do with your CakePHP template files) that you need into your javascript component files.

#### Root template:

A Root template is a file that will be loaded on the first page visit. This will be used to load your site assets (CSS and JavaScript), and will also contain a root `<div>` to boot your JavaScript application in. For more info visit [this link](https://inertiajs.com/server-side-setup#root-template).

By default, it will use the plugin's `Template/Inertia/app.ctp` file as root template.

If you want to override this, read [Overriding Plugin Templates from Inside Your Application](https://book.cakephp.org/3/en/plugins.html#overriding-plugin-templates-from-inside-your-application) section from cookbook. After creating the template file, you can use [`InertiaHelper`](https://github.com/ishanvyas22/cakephp-inertiajs/blob/master/src/View/Helper/InertiaHelper.php#L20) to quickly generate a `<div>` element.

```php
<?php

echo $this->Inertia->make($page, 'app', 'container clearfix');
```

**Output:**

```html
<div id="app" data-page="{'component':'ComponentName','url':'http://example.test','props':{...}}" class="container clearfix"></div>
```

#### Render different components:

This plugin follows same convention as CakePHP, so for `UsersController.php`'s `index` action it will render `Index.vue` component inside `Users` directory by default.

In case, you want to render any other component just set `$component` view variable and it will render that component accordingly. For example, if you want to render `Listing.vue` file inside of `Users` directory:

```php
<?php

namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function index()
    {
        $this->set('users', $this->Users->find()->toArray());
        $this->set('component', 'Users/Listing');
    }
}
```

#### Customize `beforeRender` hook:

`InertiaResponseTrait` uses `beforeRender` hook internally to handle the view specific logic. But there might be some scenarios in which you want to use this hook to manipulate or customize some behavior. Since if you will directly call `beforeRender` method in your controller, it will override whole behavior which is not what you want.

So instead you should do like this:

```php
<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Inertia\Controller\InertiaResponseTrait;

class AppController extends Controller
{
    // Alias the trait's `beforeRender` method
    use InertiaResponseTrait {
        beforeRender as protected inertiaBeforeRender;
    }

    public function beforeRender(Event $event)
    {
        static::inertiaBeforeRender($event);

        // Do your customization here.
    }
}
```

**Note:** You must have to call `beforeRender` method of `InertiaResponseTrait`, otherwise the inertia response won't work as expected.
