<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;
use App\Db;

use App\Models\User;

class Signup extends Controller
{

  public function access(): bool
  {
    if (!isShield()) {
      echo '<h1>Регистрироваться пока нельзя</h1>';
      die;
    }
    return true;
  }

  protected function handle()
  {

    if (!empty($_POST)) {
      $this->signupAction();
      die;
    }

    $this->view->countSql = Db::$countSql;

    $this->view->setCss('input');
    $this->view->setCss('alert');
    $this->view->setCss('button');

    $this->setMeta();
    $this->view->display('signup');
  }


  public function signupAction()
  {
    if (isset($_POST['password']) && isset($_POST['email'])) {
      $user = new User();
      $data = $_POST;
      $user->load($data);

      if (!$user->validate($data) || !$user->checkUnique()) {
        $user->getErrorsValidate();
        $_SESSION['form_data'] = $data;
        redirect();
      }

      $login = $this->getRandomLogin();
      $user->attributes['login'] = $login;
      $user->attributes['name'] = $login;
      $user->attributes['username'] = $login;
      $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
      $id = $user->save();
      if ($id) {
        $_SESSION['success'] = 'Вы успешно зарегистрированыю Войдите на сайт';
        redirect('/login');
      } else {
        $_SESSION['error'] = 'Ошибка! Попробуте позже';
      }

      redirect();
    }
  }

  protected function getRandomLogin()
  {
    $random = random_int(10000, 99999);
    $date = date('YmdHis');
    $login = $date . $random;
    return $login;
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
    return "Зарегистрироваться в Indyground";
  }

  protected function description()
  {
    return "Зарегистрироваться в Indyground - сайте о создателях игр, музыки, графики и всего осталнього творчества";
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
    return "page_signup";
  }
}
