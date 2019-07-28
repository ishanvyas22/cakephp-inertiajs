<?php
namespace InertiaCake\View\Helper;

use Cake\View\Helper;

/**
 * Inertia helper
 */
class InertiaHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Returns inertia div.
     *
     * @param  array $pageData Page data to set into vue.
     * @param  string $id Id attribute of the div.
     * @param  string $class Class attribute of the div.
     * @return string
     */
    public function make($pageData, $id = 'app', $class = '')
    {
        $page = json_encode($pageData);

        return sprintf(
            "<div class='%s' id='%s' data-page='%s'></div>",
            $class,
            $id,
            $page
        );
    }
}
