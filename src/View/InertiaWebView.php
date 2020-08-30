<?php
namespace Inertia\View;

use Cake\View\View;
use Inertia\View\BaseViewTrait;

/**
 * Renders `Inertia./Inertia/app` view with provided view vars.
 */
class InertiaWebView extends View
{
    use BaseViewTrait;

    /**
     * @inheritDoc
     */
    public function initialize()
    {
        $this->loadHelper('Inertia.Inertia');
        $this->loadHelper('AssetMix.AssetMix');
    }

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

        $this->set(compact('page'));

        return parent::render('Inertia./Inertia/app');
    }
}
