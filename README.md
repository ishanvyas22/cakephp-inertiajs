# CakePHP Adapter for Inertia.js

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

    **Note:** In order to use Inertia.js, you will need any one of [Client-side adapters](https://inertiajs.com/client-side-setup). This plugin leverages [AssetMix plugin](https://github.com/ishanvyas22/asset-mix/tree/cake3) so you don't have to install all the client side dependencies one by one. Instead you can directly generate scaffolding(using above command) to quickly get started.

3. Install front-end dependencies

    ```bash
    npm install
    ```

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

By default, it uses plugin's `Inertia/app.ctp` file as root template. Behind the scene it will create a `div` element with `id="app"` attribute.

#### Render different components:

This plugin follows same convention as CakePHP, so by default it will render `Index.vue` component inside `Users` directory. In case, you want to render any other component just set `$component` view variable and it will render that component accordingly. For example, if you want to render `Listing.vue` file inside of `Users` directory:

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



## Issues
Feel free to submit issues and enhancement requests.
