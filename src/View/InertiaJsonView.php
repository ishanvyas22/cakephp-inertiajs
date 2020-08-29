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
    public function render($view = null, $layout = null)
    {
        $page = [
            'component' => $this->getComponentName(),
            'url' => $this->getCurrentUri(),
            'props' => $this->getProps(),
        ];

        $this->set([
            '_serialize' => 'page',
            'page' => $page,
        ]);

        return parent::render($view, $layout);
    }
}
