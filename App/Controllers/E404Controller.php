<?php

namespace App\Controllers;

use Linna\Mvc\Controller;
use App\Models\E404Model;

class E404Controller extends Controller
{
    public function __construct(E404Model $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
    }
}
