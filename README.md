# CakePHP Adapter for Inertia.js

## Installation

1. Get project into your system via [composer](https://getcomposer.org)

    ```bash
    composer require ishanvyas22/cakephp-inertiajs
    ```

2. Load plugin into your application

    ```bash
    bin/cake plugin load Inertia
    ```

3. Generate inertia scaffolding

    ```bash
    bin/cake asset_mix generate inertia-vue
    ```

    **Note:** Above command will generate basic scaffolding to use inertia with Vue.js. For more front-end adapters please visit https://inertiajs.com/client-side-setup.

3. Install dependencies

    ```bash
    npm install
    ```

## Setup

1. Just add `Inertia\Controller\InertiaResponseTrait` into your controller in which you want to use inertia. And it will automattically render the response according to the request.

2. By default, it uses plugin's `Inertia/app.ctp` file as root template, but you can customize it according your needs via `InertiaHelper`:

    First load Inertia helper into your ``AppView.php`` file:
    ```
    $this->loadHelper('Inertia.Inertia');
    ```

    In your template file add below lines:
    ```
    echo $this->Inertia->make($data, ['id' => 'app']);
    ```

    Behind the scene it will create a `div` element with `id="app"` attribute. You can change ``app`` id according to your convenience.

## Creating responses

To create an inertia response you just have to use `InertiaResponseTrait` that ships with this plugin. This will handle all the heavy lifting that is needed render your view/component.

```php
<?php

namespace App\Controller;

use Inertia\Controller\InertiaResponseTrait;

class UsersController extends AppController
{
    use InertiaResponseTrait;

    public function index()
    {
        $this->set('users', $this->Users->find()->toArray());
    }
}
```

As you can see in above response you just have to set the variables that you need in you view, same as you do with your CakePHP template files.

It follows same convention as CakePHP, so above code will render `Index.vue` component inside `Users` directory. In case, you want to render any other component just set component view var and it will render it accordingly. For example, if you want to render `Listing.vue` file:

```php
    public function index()
    {
        $this->set('users', $this->Users->find()->toArray());
        $this->set('component', 'Users/Listing');
    }
```

#### Customize `beforeRender` hook

`InertiaResponseTrait` uses `beforeRender` hook internally to handle the view specific logic. But there might be some scenarios in which you want to use this hook to manipulate or customize some behavior. Since if you will directly call `beforeRender` method in your controller, it will override whole behavior which is not what you want.

To override `beforeRender` hook:
```php
    // Alias the trait's `beforeRender` method
    use InertiaResponseTrait {
        beforeRender as protected inertiaBeforeRender;
    }

    public function beforeRender(Event $event)
    {
        static::inertiaBeforeRender($event);

        // Do your customization here.
    }
```

**Note:** You must have to call `beforeRender` method of `InertiaResponseTrait`, otherwise the inertia response won't work as expected.

## Sharing data

Often you want to use some data across your application, for example accessing current logged in user's name or flash messages. You can easily share these type data using ``share()`` function.

Set application name:

```
$this->Inertia->share('app.name', 'Inertia');
```

Set currently logged in user's details:

```
$this->Inertia->share('auth.user', function () {
    $authUser = null;

    if ($this->Authentication->getIdentity()) {
        $authUser = $this->Authentication->getIdentity();
    }

    return $authUser;
});
```

Set flash messages:

```
$this->Inertia->share('app.flash', function () {
    return $this->Inertia->getFlashData();
});
```

## Issues
Feel free to submit issues and enhancement requests.
