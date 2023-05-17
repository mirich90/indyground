<?php

namespace App\Controllers;

use App\Controller;
use App\Meta;
use App\Errors;

use App\Models\User;

class About extends Controller
{

  protected function handle()
  {
    $this->setMeta();
    $this->view->display('about');
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
    return "О сайте Indyground";
  }

  protected function description()
  {
    return "О сайте Indyground - сайте о создателях игр, музыки, графики и всего остального творчества";
  }

  protected function keywords()
  {
    return "О сайте Indyground, Indyground, инди, RPG maker";
  }

  protected function author()
  {
    return "Yuryol";
  }

  protected function name_page()
  {
    return "page_about";
  }
}
