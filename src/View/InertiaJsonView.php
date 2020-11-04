<?php
namespace Inertia\View;

use Cake\View\JsonView;
use Inertia\View\BaseViewTrait;

/**
 * Returns json response with provided view vars.
 */
class InertiaJsonView extends JsonView
{
    use BaseViewTrait;

    /**
     * @inheritDoc
     */
    public function render(?string $view = null, $layout = null): string
    {
        $page = [
            'component' => $this->getComponentName(),
            'url' => $this->getCurrentUri(),
            'props' => $this->getProps(),
        ];

        $this->setConfig('serialize', 'page');
        $this->set([
            'page' => $page,
        ]);

        return parent::render($view, $layout);
    }
}
