<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

class Friends extends Controller
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
    $this->view->display('friends');
  }


  protected function setMeta()
  {
    $this->meta->title = $this->view->article->title;
    $this->meta->description = $this->view->article->description;
    $this->meta->keywords = $this->view->article->keywords;
    $this->meta->author = $this->view->article->author;
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
    return "Friends";
  }
}
