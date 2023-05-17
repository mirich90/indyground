<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

class Create extends Controller
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
    $this->view->setCss('image');
    $this->view->setCss('badges');
    $this->view->setJs('badges');
    $this->view->setJs('image');
    $this->view->display('create');
  }

  protected function creatArticle()
  {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
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
    return "Создать статью в Indyground";
  }

  protected function description()
  {
    return "Создать статью в Indyground - сайт о создателях игр, музыки, графики и всего осталнього творчества";
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
    return null;
  }
}
