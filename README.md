# Inertia.js CakePHP Adapter

## Installation

1. Get project into your system via [composer](https://getcomposer.org)

```bash
composer require ishanvyas22/inertia-cakephp
```

2. Load plugin into your application

```bash
bin/cake plugin load InertiaCake
```

3. Copy ``package.json`` and ``webpack.mix.js`` into root of your project then run below command (Only if you want Vue as client side adapter) for more frontend adapters please visit https://inertiajs.com/client-side-setup

```bash
npm install
```

## Setup

1. Load Inertia component into your application, provide default template file path in ``defaultTemplate`` key into ``AppController.php``

```
public function initialize()
{
    parent::initialize();

    $this->loadComponent('InertiaCake.Inertia', [
        'request' => $this->getRequest(),
        'response' => $this->getResponse(),
        'defaultTemplate' => '/Main/inertia'
    ]);
}
```

2. To setup root template, create new template file that you've provided into previous step. In our case create ``src/Template/Main/inertia.ctp``

First load Inertia helper into your ``AppView.php`` file:
```
$this->loadHelper('InertiaCake.Inertia');
```
Into ``inertia.ctp`` file:
```
echo $this->Inertia->make($page, 'app');
```

3. Additionally you can share data to use into your client side files (Optional)

```
$this->Inertia->share('app.name', 'InertiaCake');

$this->Inertia->share('auth.user', function () {
    $authUser = null;

    if ($this->Authentication->getIdentity()) {
        $authUser = $this->Authentication->getIdentity();
    }

    return $authUser;
});

$this->Inertia->share('app.flash', function () {
    return $this->Inertia->getFlashData();
});
```

## Creating responses
To make inertia response you can simply call ``render()`` function of ``InertiaComponent``:

```
<?php

namespace App\Controller;

class UsersController extends AppController
{
    public function index()
    {
        $component = 'Users/Index';
        $props = [
            'users' => $this->Users->find()->toArray()
        ];

        return $this->Inertia->render($component, $props);
    }
}
```

By default if you have copied the ``webpack.mix.js`` file from plugin, it will render ``Index.vue`` file into ``webroot/js/Pages/Users`` directory.
