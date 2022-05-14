<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\TestHelper\Controllers;

use Linna\App\TestHelper\Models\RestModelAio;
use Linna\App\TestHelper\Views\RestViewAio;
use Linna\Mvc\Controller;
use Linna\Router\Route;

/**
 * Rest Controller all in one to mock a controller for test.
 *
 * Every method in class is a Route endpoint.
 */
class RestControllerAio extends Controller
{
    /**
     * Get all items.
     *
     * @param string $id
     *
     * @return void
     */
    #[Route(
        name:       'RestGet',
        method:     'GET',
        path:       '/rest',
        model:      RestModelAio::class,
        view:       RestViewAio::class
    )]
    public function getActionAll(): void
    {
        $this->model->getActionAll();
    }

    /**
     * Get a specific item.
     *
     * @param string $id
     *
     * @return void
     */
    #[Route(
        name:       'RestGet',
        method:     'GET',
        path:       '/rest/[id]',
        model:      RestModelAio::class,
        view:       RestViewAio::class
    )]
    public function getAction(string $id): void
    {
        $this->model->getAction((int) $id);
    }

    /**
     * Add new item.
     *
     * @return void
     */
    #[Route(
        name:       'RestPost',
        method:     'POST',
        path:       '/rest',
        model:      RestModelAio::class,
        view:       RestViewAio::class
    )]
    public function postAction(): void
    {
        $this->model->postAction();
    }

    /**
     * Update an item.
     *
     * @return void
     */
    #[Route(
        name:       'RestPut',
        method:     'PUT',
        path:       '/rest',
        model:      RestModelAio::class,
        view:       RestViewAio::class
    )]
    public function putAction(): void
    {
        $this->model->putAction();
    }

    /**
     * Delete an item.
     *
     * @param string $id
     *
     * @return void
     */
    #[Route(
        name:       'RestPut',
        method:     'DELETE',
        path:       '/rest/[id]',
        model:      RestModelAio::class,
        view:       RestViewAio::class
    )]
    public function deleteAction(string $id): void
    {
        $this->model->deleteAction((int) $id);
    }
}
