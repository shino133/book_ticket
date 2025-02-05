<?php
namespace App\Http\Controllers;

use App\Utils\AppLoader;

class HomeController extends Controller
{
  public function index()
  {
    AppLoader::view('Home');
  }
}