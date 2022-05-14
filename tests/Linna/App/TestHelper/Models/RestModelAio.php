<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\TestHelper\Models;

use Linna\Mvc\Model;

/**
 * Rest Model all in one to mock a controller for test.
 *
 */
class RestModelAio extends Model
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all items.
     *
     * @param string $id
     *
     * @return void
     */
    public function getActionAll(): void
    {
        $this->set(['action' => 'getActionAll()']);
    }

    /**
     * Get a specific item.
     *
     * @param string $id
     *
     * @return void
     */
    public function getAction(int $id): void
    {
        $this->set(['action' => "getAction({$id})"]);
    }

    /**
     * Add new item.
     *
     * @return void
     */
    public function postAction(): void
    {
        $this->set(['action' => 'postAction()']);
    }

    /**
     * Update an item.
     *
     * @return void
     */
    public function putAction(): void
    {
        $this->set(['action' => 'putAction()']);
    }

    /**
     * Delete an item.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteAction(int $id): void
    {
        $this->set(['action' => "deleteAction({$id})"]);
    }
}
