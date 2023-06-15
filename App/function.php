<?php

// красивый вар_дамп
function c($var)
{
  static $int = 0;
  echo '<pre><b style="background: cyan;padding: 1px 5px;">' . $int . '</b> ';
  var_dump($var);
  echo '</pre>';
  $int++;
}

function redirect($http = false)
{
  if ($http) {
    $redirect = $http;
  } else {
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
  }
  header("Location: $redirect");
  die;
}

function getUrl()
{
  $http = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'];
  $url = "$http://$host";
  return $url;
}

function isShield()
{
  $ip_lists = ["109.95.79.147", "127.0.0.1", "95.10.1.246"];

  // $ip_lists = [];
  // $ip_lists = ["109.95.79.147"];
  $ip = $_SERVER["REMOTE_ADDR"];
  return in_array($ip, $ip_lists);
}

function isRole($role)
{
  $user = $_SESSION['user'];
  return isset($user['role']) && $role == $user['role'];
}

function getRole()
{
  $user = $_SESSION['user'];
  $role = (isset($user['role'])) ? $user['role'] : '';
  return  $role;
}

function isLogin()
{
  $user = $_SESSION['user'];
  return isset($user['id']);
}

function hasPost($get)
{
  return isset($_POST[$get]);
}

function hasGet($get)
{
  return isset($_GET[$get]);
}

function get($get)
{
  return (isset($_GET[$get])) ? $_GET[$get] : null;
}

function getUi($ui, $get)
{
  return (isset($ui[$get])) ? $ui[$get] : "";
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES);
}

function ss($name, $field, $h = false)
{
  if (isset($_SESSION[$name][$field])) {
    $return = $_SESSION[$name][$field];
    unset($_SESSION[$name]);
    return ($h) ? h($return) : $return;
  } else {
    return '';
  }
}

function parseCategories($categories)
{
  $results = array();
  foreach ($categories as $category) {
    $results[] = [
      'value' => $category['id'],
      'text' => $category['name'],
    ];
  }
  return $results;
}

function translit($value)
{
  $converter = array(
    'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
    'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
    'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
    'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
    'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
    'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
    'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
  );

  $value = mb_strtolower($value);
  $value = strtr($value, $converter);
  $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
  $value = mb_ereg_replace('[-]+', '-', $value);
  $value = trim($value, '-');

  return $value;
}

function translitSrc($str)
{
  $image_name = translit($str);
  $random = random_int(100, 999);
  $date = date('Ymd_His_');
  $src = $date . $random . "_$image_name";
  return $src;
}

function randomCode($len)
{
  $code = "";
  $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $pos = strlen($char);
  $pos = pow($pos, $len);
  $total = strlen($char) - 1;

  for ($i = 0; $i < $len; $i++) {
    $code = $code . $char[rand(0, $total)];
  }
  return $code;
}

function getImagePreview($image, $image_type)
{
  if ($image === NULL) {
    $article_src = "/img/static/category_code.jpg";
    $article_src_min = "/img/static/category_code.jpg";
  } else {
    $article_src = "/img/load/$image.$image_type";
    $article_src_min = "/img/load/min/$image.webp";
  }
  return [$article_src, $article_src_min];
}
