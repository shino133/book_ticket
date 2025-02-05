<?php
namespace App\Utils;

class AppLoader extends Loader
{ 
  public static function view($view, $data = [])
  {
    self::load($view, 'Views', $data);
  }

  public static function component($component, $data = [])
  {
    self::load($component, 'Components', $data);
  }
}