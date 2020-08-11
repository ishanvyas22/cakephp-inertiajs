<?php

namespace Inertia\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

class InertiaController extends AppController
{
    /**
     * @inheritDoc
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @inheritDoc
     */
    public function beforeRender(Event $event)
    {
        $this->setViewBuilderClass();
    }

    /**
     * Sets view class depending on detector.
     *
     * @return void
     */
    private function setViewBuilderClass()
    {
        if ($this->getRequest()->is('inertia')) {
            $this->viewBuilder()->setClassName('Json');
        }

        $this->viewBuilder()->setClassName('Inertia.Inertia');
    }
}
