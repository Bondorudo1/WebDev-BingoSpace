<?php
session_start();

if (!isset($_SESSION['authorized'])) {
  $_SESSION['authorized'] = false;
}
define('UPLOAD_DIR', 'uploads/');

try {
  error_reporting(E_ERROR | E_PARSE);
  $connection = new PDO('mysql:host=localhost;dbname=bingos', "root", "");
} catch (PDOException $e) {
  print_r("Couldnt connect to the database");
}


