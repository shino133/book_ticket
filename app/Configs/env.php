<?php
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

try {
  $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
  $dotenv->load();
} catch (InvalidPathException $e) {
  echo "File .env không tồn tại!";
  exit;
}