<?php
namespace InertiaCake\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\View\ViewVarsTrait;

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
     * Renders inertia response.
     *
     * @param  string $component Vue component to render.
     * @param  array $props Vue props to pass.
     * @return \Cake\Http\Response A response
     */
    public function render($component, $props = [])
    {
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
