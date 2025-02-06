<?php

use App\Http\Controllers\HomeController;
use App\Libs\Route;

Route::get('/', [HomeController::class, 'index']);
