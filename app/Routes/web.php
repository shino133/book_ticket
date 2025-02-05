<?php

use App\Http\Controllers\HomeController;
use App\Libs\Router;

Router::get('/', [HomeController::class, 'index']);

