<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

class NotFound extends Controller
{

  protected function handle()
  {
    $this->setMeta();
    $this->view->display('not_found');
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
    return "404 ошибка в Indyground";
  }

  protected function description()
  {
    return "404 ошибка в Indyground - сайт о создателях игр, музыки, графики и всего осталнього творчества";
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
    return "page_not_found";
  }
}
