<?php
namespace Inertia\View;

use Closure;
use Cake\Routing\Router;

trait BaseViewTrait
{
    /**
     * Get current absolute url.
     *
     * @return string
     */
    private function getCurrentUri()
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
    private function getComponentName()
    {
        if ($this->get('component') !== null) {
            $component = $this->get('component');

            unset($this->viewVars['component']);

            return $component;
        }

        return sprintf(
            '%s/%s',
            $this->getRequest()->getParam('controller'),
            ucwords($this->getRequest()->getParam('action'))
        );
    }

    /**
     * Returns `props` array excluding the default variables.
     *
     * @return array
     */
    private function getProps()
    {
        $props = [];
        $only = $this->getPartialData();
        $onlyViewVars = (! empty($only)) ? $only : array_keys($this->viewVars);
        $passedViewVars = $this->viewVars;

        $this->viewVars = [];

        foreach ($onlyViewVars as $varName) {
            if (! isset($passedViewVars[$varName])) {
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
     * Returns view variable names from `X-Inertia-Partial-Data` header.
     *
     * @return array
     */
    public function getPartialData()
    {
        if (! $this->getRequest()->is('inertia-partial-data')) {
            return [];
        }

        return explode(
            ',',
            $this->getRequest()->getHeader('X-Inertia-Partial-Data')[0]
        );
    }
}
