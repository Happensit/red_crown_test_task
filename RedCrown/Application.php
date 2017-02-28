<?php

namespace RedCrown;

use RedCrown\Di\Container;
use RedCrown\EventDispatcher\EventDispatcher;
use RedCrown\EventDispatcher\EventSubscriberInterface;
use RedCrown\Exception\ConfigureApplicationException;
use RedCrown\Exception\ExceptionEventHandler;
use RedCrown\Http\HttpEvent;
use RedCrown\Http\Router;

/**
 * Class Application
 * @package RedCrown
 */
class Application
{
    /**
     * @var
     */
    protected $environment;
    /**
     * @var Container
     */
    public $container;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var Router
     */
    public $router;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var array
     */
    protected $defaultSubscribers = [
        'exceptionEventHandler' => ExceptionEventHandler::class,
    ];

    /**
     * Application constructor.
     * @param $environment
     * @param array $config
     *   'database' => [
     *      'class' => 'RedCrown\Database\Connection',
     *      'dsn' => 'pgsql:host=172.20.0.2;dbname=redcrown',
     *      'username' => 'redcrown',
     *      'password' => 'redcrown'
     *   ]
     */
    public function __construct($environment, $config = [])
    {
        if ($environment === 'prod') {
            set_exception_handler([$this, 'exceptionHandler']);
        }

        $this->environment = $environment;
        $this->container = new Container();
        $this->router = new Router();
        $this->preInit($config);
    }

    /**
     * Run Application
     */
    public function run()
    {
        $this->router->math($_SERVER['REQUEST_URI']);
    }

    /**
     * @param $exception
     */
    public function exceptionHandler($exception)
    {
        $this->dispatcher->dispatch(
            ExceptionEventHandler::EXCEPTION,
            new HttpEvent($exception, $this->router->getErrorCallback())
        );
    }

    /**
     * @param $config
     * @throws ConfigureApplicationException
     */
    private function preInit($config)
    {
        $config['subscribers'] = !empty($config['subscribers']) ? $config['subscribers'] : [];
        $this->initializeEventSubscribers($config['subscribers']);
        unset($config['subscribers']);

        foreach ($config as $key => $properties) {
            if (empty($properties['class'])) {
                throw new ConfigureApplicationException(sprintf(
                    "'%s' key doesn't have value 'class' parameter in config file",
                    $key
                ));
            }

            $this->container->set($key, $properties);
        }
    }

    /**
     * @param $subscribers array
     */
    protected function initializeEventSubscribers(array $subscribers)
    {
        $this->dispatcher = $this->container->get(EventDispatcher::class);
        $subscribers = array_unique(array_merge($this->defaultSubscribers, $subscribers));
        foreach ($subscribers as $key => $subscriber) {
            /** @var $subscriberInstance EventSubscriberInterface */
            $subscriberInstance = $this->container->set($key, [$subscriber]);
            $this->dispatcher->addSubscriber($subscriberInstance);
        }
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        if (null === $this->rootDir) {
            $this->rootDir = dirname($_SERVER['DOCUMENT_ROOT']);
        }

        return $this->rootDir;
    }
}
