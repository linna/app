<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\TestHelper\Views;

use Linna\App\Templates\RawTemplate;
use Linna\Mvc\View;

/**
 * Rest View all in one to mock a controller for test.
 *
 */
class RestViewAio extends View
{
    /**
     * Class Constructor.
     *
     * @param RawTemplate   $rawTemplate
     */
    public function __construct(RawTemplate $rawTemplate)
    {
        parent::__construct($rawTemplate);
    }

    /**
     * Get all items.
     *
     * @return void
     */
    public function getActionAll(): void
    {
        $this->data['action'] = 'View getActionAll(): '.$this->data['action'];
    }

    /**
     * Get a specific item.
     *
     * @param string $id
     *
     * @return void
     */
    public function getAction(): void
    {
        $this->data['action'] = 'View getAction(): '.$this->data['action'];
    }

    /**
     * Add new item.
     *
     * @return void
     */
    public function postAction(): void
    {
        $this->data['action'] = 'View postAction(): '.$this->data['action'];
    }

    /**
     * Update an item.
     *
     * @return void
     */
    public function putAction(): void
    {
        $this->data['action'] = 'View putAction(): '.$this->data['action'];
    }

    /**
     * Delete an item.
     *
     * @return void
     */
    public function deleteAction(): void
    {
        $this->data['action'] = 'View deleteAction(): '.$this->data['action'];
    }
}
