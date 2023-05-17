<?php
// require __DIR__ . '/../App/autoload.php'; //автозагрузчик без композера
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../App/function.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$ctrl = $parts[1] ? $parts[1] : 'Index';
$ctrl = ucfirst($ctrl);

try {

  $file = __DIR__ . "/../App/Controllers/$ctrl.php";
  if (file_exists($file)) {
    $class = "\App\Controllers\\$ctrl";
  } else {
    $class = '\App\Controllers\NotFound';
  }

  $ctrl = new $class;
  $ctrl();
} catch (\App\DbException $error) {

  echo 'Ошибка в БД: ' . $error->getMessage();
  die;
} catch (\App\Errors $errors) {

  foreach ($errors->all() as $error) {
    echo 'Ошибка: ' . $error->getMessage();
    echo '<br />';
  }
}
