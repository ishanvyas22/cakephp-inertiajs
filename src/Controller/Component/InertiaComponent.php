<?php
namespace InertiaCake\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\View\ViewVarsTrait;
use Closure;

/**
 * Inertial component
 */
class InertiaComponent extends Component
{
    use ViewVarsTrait;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'headers' => [
            'Vary' => 'Accept',
            'X-Inertia' => 'true',
        ]
    ];

    /**
     * Server request.
     *
     * @var null|\Cake\Http\Request
     */
    protected $_serverRequest = null;

    /**
     * Server response.
     *
     * @var null|\Cake\Http\Response
     */
    protected $_serverResponse = null;

    /**
     * Contains current controller object.
     *
     * @var null|object
     */
    protected $_controller = null;

    /**
     * Shared props array
     *
     * @var array
     */
    protected $_sharedProps = [];

    /**
     * Shared props closure to pass
     *
     * @var array|\Closure
     */
    protected $_sharedPropsCallbacks = [];

    /**
     * Inertia header version.
     *
     * @var null|string
     */
    protected $_version = null;

    /**
     * Initialization hook.
     *
     * @param  array $config Configuration array.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->_serverRequest = $config['request'];
        $this->_serverResponse = $config['response'];
        $this->_controller = $this->_registry->getController();

        if (isset($config['defaultLayout'])) {
            $this->setDefaultLayout($config['defaultLayout']);
        }

        if (isset($config['defaultTemplate'])) {
            $this->setDefaultTemplate($config['defaultTemplate']);
        }

        if (isset($config['sharedProps']) && empty($config['sharedProps'])) {
            $this->_sharedProps = array_merge(
                $this->_sharedProps,
                $config['sharedProps']
            );
        }
    }

    /**
     * Startup callback.
     *
     * @param \Cake\Event\Event $event Event instance.
     * @return void
     */
    public function startup(Event $event)
    {
    }

    /**
     * Share data with all your components.
     *
     * @param  string|\Closure $key Key for the data or closure.
     * @param  string|null $value Value to set with the given key.
     * @return void
     */
    public function share($key, $value = null)
    {
        if ($key instanceof Closure) {
            $this->_sharedPropsCallbacks[] = $key;
        } else {
            $this->_sharedProps = Hash::insert($this->_sharedProps, $key, $value);
        }
    }

    /**
     * Returns shared data array.
     *
     * @param  null|string $key Get specific key value, return full array if null.
     * @return array
     */
    public function getShared($key = null)
    {
        if ($key !== null) {
            return Hash::get($this->_sharedProps, $key);
        }

        return $this->_sharedProps;
    }

    /**
     * Set inertia header version
     *
     * @param  string $version Inertia version.
     * @return void
     */
    public function version($version)
    {
        $this->_version = $version;
    }

    /**
     * Returns inertia version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Renders inertia response.
     *
     * @param  string $component Vue component to render.
     * @param  array $props Vue props to pass.
     * @return \Cake\Http\Response A response
     */
    public function render($component, $props = [])
    {
        $only = [];

        if ($this->_serverRequest->hasHeader('X-Inertia-Partial-Data')) {
            $only = array_filter(explode(
                ',',
                $this->_serverRequest->getHeader('X-Inertia-Partial-Data')
            ));
        }

        $props = array_merge($this->_sharedProps, $props);

        foreach ($this->_sharedPropsCallbacks as $callback) {
            // $props = array_merge($props, App::call($callback));
            $props = array_merge($props, $callback());
        }

        array_walk_recursive($props, function (&$prop) {
            if ($prop instanceof Closure) {
                $prop = $prop();
            }
        });

        if ($only && $this->_serverRequest->getHeader('X-Inertia-Partial-Component') === $component) {
            $props = array_intersect_key($props, array_flip((array)$only));
        }

        $page = [
            'component' => $component,
            'props' => $props,
            'url' => $this->getCurrentUri()
        ];

        if ($this->_serverRequest->hasHeader('X-Inertia')) {
            return $this->inertiaResponse($page);
        }

        $this->_controller->set(compact('page'));
    }

    /**
     * Get current absolute url.
     *
     * @return string
     */
    private function getCurrentUri()
    {
        return Router::url($this->_serverRequest->getRequestTarget(), true);
    }

    /**
     * Returns response including required inertia js headers.
     *
     * @param  array $page Page response to set.
     * @return \Cake\Http\Response
     */
    private function inertiaResponse($page)
    {
        foreach ($this->_config['headers'] as $header => $value) {
            $this->_serverResponse = $this->_serverResponse->withHeader($header, $value);
        }

        return $this->_serverResponse
            ->withStatus(200)
            ->withType('application/json')
            ->withStringBody(json_encode($page));
    }

    /**
     * Set default layout.
     *
     * @param string $name Layout name to set.
     * @return void
     */
    private function setDefaultLayout($name)
    {
        $this->_controller->viewBuilder()->setLayout($name);
    }

    /**
     * Set template name to set.
     *
     * @param string $name Template name to set.
     * @return void
     */
    private function setDefaultTemplate($name)
    {
        $this->_controller->viewBuilder()->setTemplate($name);
    }
}
