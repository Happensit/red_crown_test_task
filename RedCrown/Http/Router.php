<?php

namespace RedCrown\Http;

use RedCrown\Exception\NotFoundHttpException;

/**
 * Class Router
 * @package RedCrown\Http
 */
class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var
     */
    private $errorCallback;

    /**
     * @param $path
     * @param $callback
     */
    public function get($path, callable $callback)
    {
        $this->add($path, $callback);
    }

    /**
     * Error handler
     * @param $callback callable
     */
    public function error(callable $callback)
    {
        $this->errorCallback = $callback;
    }

    /**
     * @return mixed
     */
    public function getErrorCallback()
    {
        return $this->errorCallback;
    }

    /**
     * @param $path
     * @param $callback
     */
    private function add($path, $callback)
    {
        $pattern = sprintf('/^%s([\/]|)$/', str_replace('/', '\/', $path));

        $this->routes[$pattern] = $callback;
    }

    /**
     * @param null $url
     * @return mixed
     * @throws \Exception
     */
    public function math($url = null)
    {
        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $params)) {
                array_shift($params);
                return call_user_func_array($callback, $params);
            }
        }

        throw new NotFoundHttpException(sprintf("Route %s Not found", $url));

    }
}
