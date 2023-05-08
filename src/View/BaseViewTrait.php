<?php
declare(strict_types=1);

namespace Inertia\View;

use Cake\Routing\Router;
use Closure;

trait BaseViewTrait
{
    /**
     * Get current absolute url.
     *
     * @return string
     */
    private function getCurrentUri(): string
    {
        return Router::url($this->getRequest()->getRequestTarget(), true);
    }

    /**
     * Returns component name.
     * If passed via contoller using `component` key, will use that.
     * Otherwise, will return the combination of controller and action.
     *
     * That means, it will generate `Users/Index` component for `UsersController.php`'s `index` action.
     *
     * @return string
     */
    private function getComponentName(): string
    {
        if ($this->get('component') !== null) {
            $component = $this->get('component');

            unset($this->viewVars['component']);

            return $component;
        }

        return sprintf(
            '%s/%s',
            $this->getRequest()->getParam('controller'),
            ucwords((string)$this->getRequest()->getParam('action'))
        );
    }

    /**
     * Returns `props` array excluding the default variables.
     *
     * @return array
     */
    private function getProps(): array
    {
        $props = [];
        $only = $this->getPartialData();
        $onlyViewVars = !empty($only) ? $only : array_keys($this->viewVars);
        $passedViewVars = $this->viewVars;

        $nonInertiaProps = $this->getConfig('_nonInertiaProps') ?? [];

        $onlyViewVars = array_diff($onlyViewVars, $nonInertiaProps);

        $this->viewVars = array_intersect_key(
            $passedViewVars,
            array_flip($nonInertiaProps)
        );

        foreach ($onlyViewVars as $varName) {
            if (!isset($passedViewVars[$varName])) {
                continue;
            }

            $prop = $passedViewVars[$varName];

            if ($prop instanceof Closure) {
                $props[$varName] = $prop();
            } else {
                $props[$varName] = $prop;
            }
        }

        return $props;
    }

    /**
     * Any viewVars that should not be included in Inertia `page`
     * are set here
     *
     * @param mixed $props The view vars
     * @param mixed $nonInertiaVars Array of non Inertia Vars
     * @return array
     */
    private function setNonInertiaVars($props, $nonInertiaVars): array
    {
        if (!is_array($nonInertiaVars)) {
            $nonInertiaVars = [$nonInertiaVars];
        }

        $notInertiaProps = [];

        foreach ($nonInertiaVars as $prop) {
            if (isset($props[$prop])) {
                $this->set($prop, $props[$prop]);

                $notInertiaProps[] = $prop;
            }
        }

        // remove the notInertiaVars so they don't appear in Inertia `page`
        return array_diff_key(
            $props,
            array_flip($notInertiaProps)
        );
    }

    /**
     * Returns view variable names from `X-Inertia-Partial-Data` header.
     *
     * @return array
     */
    public function getPartialData(): array
    {
        if (!$this->getRequest()->is('inertia-partial-data')) {
            return [];
        }

        return explode(
            ',',
            $this->getRequest()->getHeader('X-Inertia-Partial-Data')[0]
        );
    }
}
