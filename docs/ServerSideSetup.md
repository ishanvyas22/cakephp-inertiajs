# Usage

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

### Root template

A Root template is a file that will be loaded on the first page visit. This will be used to load your site assets (CSS and JavaScript), and will also contain a root `<div>` to boot your JavaScript application in. For more info visit [this link](https://inertiajs.com/server-side-setup#root-template).

By default, it will use the plugin's `Template/Inertia/app.php` file as root template.

If you want to override this, read [Overriding Plugin Templates from Inside Your Application](https://book.cakephp.org/4/en/plugins.html#overriding-plugin-templates-from-inside-your-application) section from cookbook. After creating the template file, you can use [`InertiaHelper`](https://github.com/ishanvyas22/cakephp-inertiajs/blob/master/src/View/Helper/InertiaHelper.php#L20) to quickly generate a `<div>` element.

```php
<?php

echo $this->Inertia->make($page, 'app', 'container clearfix');
```

**Output:**

```html
<div id="app" data-page="{'component':'ComponentName','url':'http://example.test','props':{...}}" class="container clearfix"></div>
```

### Render different components

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

### Customize `beforeRender` hook

`InertiaResponseTrait` uses `beforeRender` hook internally to handle the view specific logic. But there might be some scenarios in which you want to use this hook to manipulate or customize some behavior. Since if you will directly call `beforeRender` method in your controller, it will override whole behavior which is not what you want.

So instead you should do like this:

```php
<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Inertia\Controller\InertiaResponseTrait;

class AppController extends Controller
{
    // Alias the trait's `beforeRender` method
    use InertiaResponseTrait {
        beforeRender as protected inertiaBeforeRender;
    }

    public function beforeRender(EventInterface $event)
    {
        $this->inertiaBeforeRender($event);

        // Do your customization here.
    }
}
```

**Note:** You must have to call `beforeRender` method of `InertiaResponseTrait`, otherwise the inertia response won't work as expected.

### Flash messages

When working with CakePHP we often use Flash messages to set one-time notification message to acknowledge user that particular action has succeeded or not. This plugin makes it easier to work with Flash messages, because you don't have to do anything extra make flash messages work.

To pass flash data into the front-end component, you simply have to set flash message as you normally would:

```php
$this->Flash->success('It worked!');
```
That's it! The flash data will automatically pass to component as a `Array` for you to use.

### Integrating Inertia with CakePHP layout and template elements

To include a mix of legacy CakePHP elements (such as a menu system) with Inertia components tell Inertia which view variables NOT to include in the root Inertia `div` using the `$_nonInteriaProps` class property

In `AppController` (to globally set the Non-Interia vars) or a child that inherits from it (to make the change per Controller) set the `$_nonInertiaProps` class property to an array of View Vars:


```php
<?php

namespace App\Controller;

use Cake\Core\Configure
use Cake\Event\EventInterface;
use Inertia\Controller\InertiaResponseTrait;

class ExamplesController extends AppController
{
    // use a class property
    protected array $_nonInertiaProps = [
            'menu',
            'user'
    ];

    // Or read from your configuration 
    // in the `initialize` method
    // public function initialize(): void
    // {
    //     parent::initialize();
    //
    //     $this->_nonInertiaProps = Configure::read('NON_INERTIA_PROPS')
    // }

    // See `Customize beforeRender hook` regarding further customization

    public function index() {
        // menu array
        $menu = $this->Examples->Menus->find('threaded');

        // user info to display logged in user in menu
        $user = $this->Authentication->getIndentity();

        $examples = $this->Examples->find('all);

        // `menu` and `user` will be available to CakePHP view elements
        // `examples` will be available to Inertia Components
        $this->set(compact('menu', 'user', 'examples'));
    }
}
```

---

[< Installation](Installation.md) | [Client-side Setup >](ClientSideSetup.md)
