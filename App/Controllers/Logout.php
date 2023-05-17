<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

class Logout extends Controller
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
    $this->setMeta();
    $this->logoutAction();
  }

  public function logoutAction()
  {

    if (isset($_SESSION['user'])) {
      unset($_SESSION['user']);
    }

    redirect('/login');
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
    return "page_logout";
  }
}
