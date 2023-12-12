<?php
declare(strict_types=1);

namespace Inertia\View;

use Cake\View\View;

/**
 * Renders `Inertia./Inertia/app` view with provided view vars.
 */
class InertiaWebView extends View
{
    use BaseViewTrait;

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        $this->loadHelper('Inertia.Inertia');
        $this->loadHelper('AssetMix.AssetMix');
    }

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

        $this->set(compact('page'));

        return parent::render('Inertia./Inertia/app');
    }
}
