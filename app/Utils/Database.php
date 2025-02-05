<?php
namespace App\Utils;

use PDO;
use PDOException;

class Database
{
  private static ?PDO $pdo = null;

  public static function getConnection(): PDO
  {
    if (self::$pdo === null) {
      self::setConnection();
    }
    return self::$pdo;
  }

  public static function setConnection()
  {
    try {
      $database = AppLoader::env('DB_DATABASE');
      $host = AppLoader::env('DB_HOST');
      $dbname = AppLoader::env('DB_NAME');
      $username = AppLoader::env('DB_USERNAME');
      $password = AppLoader::env('DB_PASSWORD');

      self::$pdo = new PDO(
        "$database:host=$host;dbname=$dbname",
        $username,
        $password
      );
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Database connection failed: ".$e->getMessage());
    }
  }

  public static function closeConnection()
  {
    self::$pdo = null;
  }
}
