<?php
declare(strict_types=1);

namespace TestApp\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Inertia\Controller\InertiaResponseTrait;

class AppController extends Controller
{
    use InertiaResponseTrait;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Share data throughout the application
        $this->set('app', [
            'name' => 'InertiaTestApp',
        ]);
        $this->set('auth', function () {
            return ['user' => null];
        });
    }
}
