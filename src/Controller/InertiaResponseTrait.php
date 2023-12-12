<?php
declare(strict_types=1);

namespace Inertia\Controller;

use Cake\Event\EventInterface;
use Inertia\Utility\Message;

trait InertiaResponseTrait
{
    /**
     * @inheritDoc
     */
    public function beforeRender(EventInterface $event): mixed
    {
        if ($this->isErrorStatus() || $this->isFailureStatus()) {
            return null;
        }

        $this->setViewBuilderClass();

        $this->setFlashData();

        $this->setCsrfToken();

        $this->setNonInertiaProps();
    }

    /**
     * Sets array of view variables for Inertia to ignore for use
     * by Non-Inertia view elements
     *
     * @return void
     */
    private function setNonInertiaProps(): void
    {
        if (!property_exists($this, '_nonInertiaProps')) {
            return;
        }

        $nonInertiaProps = $this->_nonInertiaProps;

        if (is_string($nonInertiaProps)) {
            $nonInertiaProps = [$nonInertiaProps];
        }

        $this->viewbuilder()
            ->setOption('_nonInertiaProps', $nonInertiaProps);
    }

    /**
     * Sets view class depending on detector.
     *
     * @return void
     */
    private function setViewBuilderClass(): void
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
    private function isErrorStatus(): bool
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
    private function isFailureStatus(): bool
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
    protected function setFlashData(): void
    {
        /** @var \Cake\Http\Session $session */
        $session = $this->getRequest()->getSession();

        $this->set('flash', function () use ($session) {
            if (!$session->check('Flash.flash.0')) {
                return [];
            }

            $flash = $session->read('Flash.flash.0');

            $flash['element'] = strtolower(str_replace('/', '-', $flash['element']));

            $session->delete('Flash');

            return $flash;
        });
    }

    /**
     * Sets `_csrfToken` field to pass into every front-end component.
     *
     * @return void
     */
    private function setCsrfToken(): void
    {
        $this->set('_csrfToken', $this->getRequest()->getAttribute('csrfToken'));
    }
}
