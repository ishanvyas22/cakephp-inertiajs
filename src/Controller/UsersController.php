<?php

namespace InertiaCake\Controller;

use Cake\Event\Event;
use InertiaCake\Controller\AppController as AppController;

class UsersController extends AppController
{

    /**
     * Initialization hook.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Before filter hook.
     *
     * @param  Event $event Event boject
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->loadComponent('InertiaCake.Inertia', [
            'request' => $this->getRequest(),
            'response' => $this->getResponse()
        ]);
    }

    /**
     * Index method.
     *
     * @return \Cake\Http\Response|string
     */
    public function index()
    {
        $component = 'Welcome';
        $props = [];

        return $this->Inertia->render($component, $props);
    }

    /**
     * About method.
     *
     * @return \Cake\Http\Response|string
     */
    public function about()
    {
        $component = 'About';
        $props = [];

        return $this->Inertia->render($component, $props);
    }

    /**
     * Contact method.
     *
     * @return \Cake\Http\Response|string
     */
    public function contact()
    {
        $component = 'Contact';
        $props = [];

        return $this->Inertia->render($component, $props);
    }
}
