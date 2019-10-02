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

3. Copy ``package.json`` and ``webpack.mix.js`` into root of your project then run below command

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
