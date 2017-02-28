<?php

namespace RedCrown\Di;

/**
 * Interface ContainerInterface
 * @package RedCrown\Container
 */
interface ContainerInterface
{
    /**
     * @param $className
     * @return object
     */
    public function get($className);
}
