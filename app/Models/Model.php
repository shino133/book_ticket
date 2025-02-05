<?php
namespace App\Models;

use App\Utils\Database;
use PDO;
use PDOStatement;

class Model
{
  protected static ?string $sql = null;

  public static function query(string $sql): PDOStatement
  {
    self::setSql($sql);
    $stmt = self::getPdo()->prepare(self::getSql());
    $stmt->execute();
    self::destroy();
    return $stmt;
  }

  public static function getSql(): ?string
  {
    return self::$sql;
  }

  public static function setSql(?string $sql): void
  {
    self::$sql = $sql;
  }

  public static function getPdo(): PDO
  {
    return Database::getConnection();
  }

  public static function destroy(): void
  {
    self::$sql = null;
    Database::closeConnection();
  }
}
