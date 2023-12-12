<?php
declare(strict_types=1);

namespace Inertia\View;

use Cake\View\JsonView;

/**
 * Returns json response with provided view vars.
 */
class InertiaJsonView extends JsonView
{
    use BaseViewTrait;

    /**
     * @inheritDoc
     */
    public function render(?string $view = null, string|false|null $layout = null): string
    {
        $page = [
            'component' => $this->getComponentName(),
            'url' => $this->getCurrentUri(),
            'props' => $this->getProps(),
        ];

        $this->setConfig('serialize', 'page');

        $this->set(compact('page'));

        return parent::render($view, $layout);
    }
}
