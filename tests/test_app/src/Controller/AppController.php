<?php

namespace TestApp\Controller;

use Cake\Event\Event;
use Cake\Controller\Controller;
use Inertia\Controller\InertiaResponse;

class AppController extends Controller
{
    use InertiaResponse;

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
            'name' => 'InertiaDemo',
            'flash' => null,
            'user' => function () {
                $authUser = null;

                if ($this->Authentication->getIdentity()) {
                    $authUser = $this->Authentication->getIdentity();
                }

                return $authUser;
            }
        ]);
    }
}
