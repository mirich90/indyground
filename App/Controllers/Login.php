<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

use App\Models\User;

class Login extends Controller
{
  public function access(): bool
  {
    if (!isShield()) {
      redirect('/NotFound');
      die;
    }
    return true;
  }

  protected function handle()
  {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
      $this->loginAction();
      die;
    }

    $this->view->setCss('input');
    $this->view->setCss('alert');
    $this->view->setCss('button');

    $this->setMeta();
    $this->view->display('login');
  }

  public function loginAction()
  {
    if (isset($_POST['email']) && isset($_POST['password'])) {
      $user = new User();
      $data = $_POST;
      $user->load($data);
      if ($user->login()) {
        $_SESSION['success'] = 'Вы успешно авторизованы';
        redirect('/');
      } else {
        $_SESSION['error'] = 'Логин или пароль введены неверно';
        redirect('/login');
      }
    }
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
    return "Вход в Indyground";
  }

  protected function description()
  {
    return "Вход в Indyground - сайт о создателях игр, музыки, графики и всего осталнього творчества";
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
    return "page_login";
  }
}
