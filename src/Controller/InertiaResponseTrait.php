<?php

namespace Inertia\Controller;

use Cake\Event\Event;

trait InertiaResponseTrait
{
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
        $viewClass = 'InertiaWeb';
        if ($this->getRequest()->is('inertia')) {
            $viewClass = 'InertiaJson';
        }

        $this->viewBuilder()->setClassName("Inertia.{$viewClass}");
    }
}
