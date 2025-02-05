<?php
namespace App\Utils;

class Loader
{
  protected static $basePath;

  public static function setBasePath($path)
  {
    self::$basePath = $path;
  }

  public static function env($key, $default = null)
  {
    return $_ENV[$key] ?? $default;
  }

  public static function require($file, $require_once = true, $data = [])
  {
    $file = self::$basePath.'/'.$file;
    extract($data);
    if ($require_once) {
      require_once $file;
    } else {
      require $file;
    }
  }

  public static function dd($value)
  {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    exit;
  }

  public static function include($file, $include_once = true, $data = [])
  {
    $file = self::$basePath.'/'.$file;
    extract($data);

    if ($include_once) {
      include_once $file;
    } else {
      include $file;
    }
  }

  public static function replaceDot($string)
  {
    return str_replace(['.', '/', '\\'], DIRECTORY_SEPARATOR, $string);
  }

  public static function load($filePath,$folder, $data = [])
  {
    $file = self::replaceDot($filePath);

    self::include(
      file: $folder.DIRECTORY_SEPARATOR.$file.'.php',
      include_once: false,
      data: $data);
  }
}