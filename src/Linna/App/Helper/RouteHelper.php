<?php

/**
 * Linna Framework.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Helper;

use Linna\Router\RouteCollection;
use Linna\Router\Route;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

/**
 * Route Helper.
 *
 * Translate annotation in controllers to make application routes as route
 * collection
 */
class RouteHelper
{
    /**
     * Class Contructor.
     *
     * @param string $controllerFolder
     * @param string $namespace
     */
    public function __construct(
        private string $controllerFolder,
        private string $namespace
    ) {
        if ($namespace[-1] !== '\\') {
            $this->namespace = "{$namespace}\\";
        }
    }

    /**
     * Generate Route collection starting from controllers.
     *
     * @return RouteCollection
     */
    public function generate(): RouteCollection
    {
        $classes = $this->readControllers();
        //var_dump($classes);
        $routes = new RouteCollection();
        $methods = [];

        // for every controller in controller folder
        foreach ($classes as $class) {
            $reflectorClass = new ReflectionClass($class);
            // create reflection class and get attributes if attribute is istance of Route
            foreach ($reflectorClass->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
                // create new route instance using as arguments the attribute arguments plus the controller class
                $routes[] =(new ReflectionClass(Route::class)
                    )->newInstanceArgs($attribute->getArguments() +
                    ['controller' => $class]);
            }

            // get method for further routes that have actions
            foreach ($reflectorClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $methods[] = [$class, $method];
            }
        }

        // for every method of controllers
        foreach ($methods as $method) {
            // unpack method and class
            [$class, $method] = $method;
            // create reflection class and get attributes if attribute is istance of Route
            foreach ($method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
                // create new route instance using as arguments the attribute arguments plus the controller class
                // and the action
                $routes[] =(new ReflectionClass(Route::class))
                    ->newInstanceArgs($attribute->getArguments() +
                    ['action' => $method->getName(), 'controller' => $class]);
            }
        }

        return $routes;
    }

    /**
     * Generate a list of classes starting from controller files.
     *
     * @return array
     */
    private function readControllers(): array
    {
        $files = \glob("{$this->controllerFolder}/*.php");
        $classes = [];

        foreach ($files as $file) {
            $classes[] = $this->namespace.\pathinfo($file, PATHINFO_FILENAME);
        }

        return $classes;
    }
}
