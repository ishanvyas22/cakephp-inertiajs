<?php

namespace TestApp\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Inertia\Controller\InertiaResponseTrait;

class AppController extends Controller
{
    use InertiaResponseTrait;

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // Share data throughout the application
        $this->set('app', [
            'name' => 'InertiaTestApp',
        ]);
        $this->set('flash', function () {
            return ['message' => null];
        });
        $this->set('auth', function () {
            return ['user' => null];
        });
    }
}
