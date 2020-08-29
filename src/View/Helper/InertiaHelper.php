<?php
namespace Inertia\View\Helper;

use Cake\View\Helper;

/**
 * Inertia helper
 */
class InertiaHelper extends Helper
{

    /**
     * Returns inertia div.
     *
     * @param  array $pageData Page data to set into component.
     * @param  string $id Id attribute of the div.
     * @param  string $class Class attribute of the div.
     * @return string
     */
    public function make($pageData, $id = 'app', $class = '')
    {
        return sprintf(
            '<div id="%s" data-page="%s" class="%s"></div>',
            $id,
            json_encode($pageData),
            $class
        );
    }
}
