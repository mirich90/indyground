<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Article;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Comment;

// use App\Controllers\Article as ControllersArticle;

class Api extends Controller
{
  private $IS_AUTH = false;
  private $USER_ROLE = '';
  private $PATH = array();
  private $DATA = array();

  public function access(): bool
  {

    // if (isset($_SESSION['user'])) {
    $this->IS_AUTH = isLogin();
    $this->USER_ROLE = getRole();
    $this->PATH =  explode('/', $_SERVER['REQUEST_URI']);
    // }
    // } else if (isset($_POST['loadComments'])) {
    //   // $this->loadComments($_POST['sort']);
    //   die;
    // } else if (!empty($_POST)) {
    //   // $this->add();
    //   die;
    // }
    // return isset($_GET['role']) && 'admin' == $_GET['role'];
    return true;
  }

  protected function handle()
  {
    $article = new \App\Models\Article();
    $Content = new \App\Models\Content();

    // c($_GET);
    // c($this->USER_ROLE);
    // c($this->PATH);
    // die;

    $this->setMeta();

    if ($this->PATH[2] === "articles") $DATA = $this->getArticles();

    $response = [];
    $response['status'] = 200;
    $response['message'] = 'ok';
    $response['data'] = json_encode($DATA, JSON_UNESCAPED_UNICODE);
    c(json_decode($response['data']));
    // $this->view->display('article');
  }


  protected function getArticles()
  {
    $article = new Article;
    return $article->findAll();
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
    return "API для Indyground";
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
    return "api";
  }
}
