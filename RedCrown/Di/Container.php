<?php

namespace RedCrown\Di;

/**
 * Class Container
 * @package RedCrown\Container
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $classes = [];

    /**
     * @param $className
     * @param array $dependencies
     * @return object
     */
    public function get($className, $dependencies = [])
    {

        if (isset($this->classes[$className])) {
            return $this->classes[$className];
        }

        $reflection = new \ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        if ($constructor) {
            foreach ($constructor->getParameters() as $param) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    $class = $param->getClass();
                    if ($class) {
                        $dependencies[] = self::get($class->getName());
                    }
                }
            }
        }

        $object = $reflection->newInstanceArgs($dependencies);

        return $this->classes[$className] = $object;

    }

    /**
     * @param $class
     * @param array $definition
     * @return object
     */
    public function set($class, $definition = [])
    {
        if (empty($definition)) {
            return $this->get($class);
        }

       return $this->classes[$class] = $this->get(array_shift($definition), $definition);

    }
}