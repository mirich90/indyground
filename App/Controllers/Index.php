<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Db;

class Index extends Controller
{
  protected function handle()
  {
    $article = new Article;
    $Category = new Category;
    $this->test();
    $this->setMeta();
    $tag = get("tag");
    $category =  get("category");
    $this->view->articles = $article->findAll();
    $this->view->categories = $Category->findAll('ASC');

    if ($tag) {
      $this->view->h1 = "с тегом #$tag";
    }
    // var_dump($this->view->articles[0]);
    // var_dump(count($this->view->articles));
    // die;
    if ($category) {
      $category_name = $this->view->categories[$category - 1]['name'];
      $this->view->h1 = "из категории '$category_name'";
    }
    // $this->view->article = $article->findOne(3);
    $this->view->setCss('input');

    $this->view->setCss('index');
    $this->view->setJs('filter');

    $this->view->display('index');
  }

  protected function setMeta()
  {
    $this->meta->title = $this->title();
    $this->meta->description = $this->description();
    $this->meta->keywords = $this->keywords();
    $this->meta->author = $this->author();
    $this->meta->name_page = $this->name_page();
    $this->view->meta = $this->meta;
  }

  protected function title()
  {
    return "Indyground";
  }

  protected function description()
  {
    return "Indyground - сайт о создателях игр, музыки, графики и всего осталнього творчества";
  }

  protected function keywords()
  {
    return "Indyground, инди, RPG maker";
  }

  protected function author()
  {
    return "Yuryol";
  }

  protected function name_page()
  {
    return "page_index";
  }


  private function test()
  {
    $tests = [];
    $tests[] = $this->testBd();
    $tests[] = $this->testJson();
    $tests = array_diff($tests, array(0, null));

    if (!empty($tests)) {
      echo json_encode($tests);
      die;
    }
  }

  private function testBd()
  {
    if (!empty($_POST['testBd'])) {
      $articles = new Article;
      return json_encode($this->view->articles = $articles->findAll(), JSON_UNESCAPED_UNICODE);
    }
  }

  private function testJson()
  {
    if (!empty($_POST['testJson'])) {
      return json_encode(array(
        'user' => 0
      ));
    }
  }

  function getInfo()
  {
    $info = [];
    $info[] = getenv('REMOTE_ADDR'); //IP-адрес посетителя
    $info[] = getenv('HTTP_USER_AGENT'); //Браузер посетителя

    return $info;


    // screen.width //ширина экрана монитора
    // screen.height //высота экрана монитора
    // screen.colorDepth //Битовая глубина цветовой гаммы
    // screen.pixelDepth //Разрешение экрана монитора
    // navigator.appCodeName //Кодовое имя браузера.
    // navigator.appName //Имя браузера / Тип броузера
    // navigator.userAgent //Агент пользователя
    // navigator.appVersion  //Версия броузера
    // lnavigator.language  //Язык броузера
    // navigator.platform // ОС
    // navigator.javaEnabled // Проверяет, включён ли Java.
    // navigator.plugins[row].description // Установленные плагины
    // navigator.mimeTypes //Типы файлов (MIME)
    // appCodeName  //номер кода приложения
    // cpuClass // Класс процессора (x86 и пр.).
    // systemLanguage // Системный язык
    // appMinorVersion // Минор-версия приложения
    // //Узнать имя пользователя (IE):
    // var ws = new ActiveXObject("WScript.Network");
    // ws.ComputerName + " " + ws.UserName;

  }
  function getRealIp()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}
