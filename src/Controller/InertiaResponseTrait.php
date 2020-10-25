<?php

namespace Inertia\Controller;

use Cake\Event\Event;
use Inertia\Utility\Message;

trait InertiaResponseTrait
{
    /**
     * @inheritDoc
     */
    public function beforeRender(Event $event)
    {
        if ($this->isErrorStatus() || $this->isFailureStatus()) {
            return null;
        }

        $this->setViewBuilderClass();

        $this->setFlashData();
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

    /**
     * Checks if response status code is 404.
     *
     * @return bool Returns true if response is error, false otherwise.
     */
    private function isErrorStatus()
    {
        $statusCode = $this->getResponse()->getStatusCode();
        $errorCodes = [
            Message::STATUS_NOT_FOUND,
        ];

        if (in_array($statusCode, $errorCodes)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if response status code is 500.
     *
     * @return bool Returns true if response is failure, false otherwise.
     */
    private function isFailureStatus()
    {
        $statusCode = $this->getResponse()->getStatusCode();
        $failureCodes = [
            Message::STATUS_INTERNAL_SERVER,
        ];

        if (in_array($statusCode, $failureCodes)) {
            return true;
        }

        return false;
    }

    /**
     * Sets flash data, and deletes after setting it.
     *
     * @return void
     */
    protected function setFlashData()
    {
        /** @var \Cake\Http\Session */
        $session = $this->getRequest()->getSession();

        $this->set('flash', function () use ($session) {
            if (! $session->check('Flash.flash.0')) {
                return [];
            }

            $flash = $session->read('Flash.flash.0');

            $flash['element'] = strtolower(str_replace('/', '-', $flash['element']));

            $session->delete('Flash');

            return $flash;
        });
    }
}
