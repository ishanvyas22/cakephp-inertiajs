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
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $this->setViewBuilderClass();
    }

    /**
     * Sets view class depending on detector.
     *
     * @return void
     */
    private function setViewBuilderClass()
    {
        $viewClass = 'InertiaWeb';
        if ($this->getRequest()->is('inertia')) {
            $viewClass = 'InertiaJson';
        }

        $this->viewBuilder()->setClassName("Inertia.{$viewClass}");
    }
}
