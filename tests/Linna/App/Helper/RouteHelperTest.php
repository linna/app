<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2022, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Helper;

use Linna\Container\Container;
use Linna\Router\Router;
use Linna\Router\Route;
use Linna\Router\RouteCollection;
use Linna\Mvc\ModelViewController;
use Linna\Mvc\Model;
use PHPUnit\Framework\TestCase;

/**
 * Route Helper Test
 *
 */
class RouteHelperTest extends TestCase
{
    /**
     * @var RouteCollection Routes for test.
     */
    protected static RouteCollection $routes;

    /**
     * @var Router The router object.
     */
    protected static RouteHelper $helper;

    /**
     * Test new instance.
     *
     * @return void
     */
    public function testRouteHelperInstance(): void
    {
        static::$helper = new RouteHelper(\dirname(__DIR__).'/TestHelper/Controllers', 'Linna\App\TestHelper\Controllers');
        $this->assertInstanceOf(RouteHelper::class, static::$helper);
    }

    /**
     * Test route generation.
     *
     * @return void
     */
    public function testGenerateRoutes(): void
    {
        $routes = static::$helper->generate();
        $this->assertInstanceOf(RouteCollection::class, $routes);

        foreach ($routes as $route) {
            $this->assertInstanceOf(Route::class, $route);
        }
    }

    /**
     * Calculator multi provider.
     *
     * @return array
     */
    public function routesProvider(): array
    {
        return [
            ['/rest', 'GET', 'View getActionAll(): getActionAll()'],
            ['/rest/5','GET', 'View getAction(): getAction(5)'],
            ['/rest/6','GET', 'View getAction(): getAction(6)'],
            ['/rest', 'POST', 'View postAction(): postAction()'],
            ['/rest', 'PUT', 'View putAction(): putAction()'],
            ['/rest/5','DELETE', 'View deleteAction(): deleteAction(5)'],
            ['/rest/6','DELETE', 'View deleteAction(): deleteAction(6)']
        ];
    }

    /**
     * Test generated routes.
     *
     * @dataProvider routesProvider
     *
     * @param string $route
     * @param string $method
     * @param string $result
     *
     * @return void
     */
    public function testGeneratedRoutes(string $route, string $method, string $result): void
    {
        $router = new Router(
            static::$helper->generate(),
            rewriteMode: true,
        );

        $router->validate($route, $method);

        $routeValidated = $router->getRoute();

        $container = new Container();

        $model = $container->resolve($routeValidated->model);
        $view = $container->resolve($routeValidated->view);

        // important, controller has a generic Model in costructor
        // need to save the required class to controller cache
        // a possible alternative could be rewrite the pettern implementing
        // the controller as SplSubject
        $container->set(Model::class, $model);
        $controller = $container->resolve($routeValidated->controller);


        $ModelViewController = new ModelViewController($model, $view, $controller, $routeValidated);
        $ModelViewController->run();

        $this->assertEquals($result, $ModelViewController->response());
    }
}
