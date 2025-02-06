<?php
namespace App\Configs;

use App\Libs\Route;
use App\Utils\AppLoader;

AppLoader::setBasePath(__DIR__.'/..');
AppLoader::require('Configs/env.php');

// Load routes
AppLoader::require('Routes/web.php');
Route::dispatch();