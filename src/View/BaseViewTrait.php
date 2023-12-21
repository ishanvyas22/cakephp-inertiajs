<?php
declare(strict_types=1);

namespace Inertia\View;

use Cake\Routing\Router;
use Closure;
use UnexpectedValueException;

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

            return $this->convertToString($component);
        }

        return sprintf(
            '%s/%s',
            $this->convertToString($this->getRequest()->getParam('controller')),
            ucwords($this->convertToString($this->getRequest()->getParam('action'))),
        );
    }

    /**
     * Helper method used to ensure correct string type.
     *
     * @param mixed $value Value
     * @return string
     * @throws \UnexpectedValueException
     */
    protected function convertToString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return (string)$value;
        }

        throw new UnexpectedValueException();
    }

    /**
     * Returns an array of Inertia var names and sets Non Inertia Vars for use by View
     *
     * @param array $only Partial Data
     * @param array $passedViewVars Associative array of all passed ViewVars and their values
     * @return array
     */
    private function filterViewVars(array $only, array $passedViewVars): array
    {
        $onlyViewVars = !empty($only) ? $only : array_keys($passedViewVars);

        /** @var array<int|string> $nonInertiaProps */
        $nonInertiaProps = $this->getConfig('_nonInertiaProps') ?? [];

        /**
         * Selects the Non-Inertia Vars to be available
         * for use outside of Inertia Components
         */
        $this->viewVars = array_intersect_key(
            $passedViewVars,
            array_flip($nonInertiaProps)
        );

        /**
         * Returns an array of the vars names which will be
         * packaged into the Inertia `page` view var
         */

        return array_diff($onlyViewVars, $nonInertiaProps);
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

        $passedViewVars = $this->viewVars;

        $onlyViewVars = $this->filterViewVars($only, $passedViewVars);

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
