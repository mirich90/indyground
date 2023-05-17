<?php

namespace App\Controllers;

use App\Controller;
use App\Components;
use App\Models;
use App\Models\Article;
use App\Models\User;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Errors;

class Profile extends Controller
{

  public function access(): bool
  {
    if (isset($_POST['loadComments'])) {
      $this->loadComments($_POST['sort']);
      die;
    }
    if (isset($_POST['action']) && $_POST['action'] === 'profileEdit') {
      $this->profileEdit($_POST['field']);
      die;
    }
    // return isset($_GET['role']) && 'admin' == $_GET['role'];
    return true;
  }

  protected function handle()
  {
    $article = new Article;
    $User_profile = new User;
    $Comment = new Comment;
    $Like = new Like;
    $Bookmark = new Bookmark;
    $username = get('username') ?: $_SESSION['user']["username"];
    $this->view->user_profile = $User_profile->findAllBy("username = '$username'")[0];
    $user_id = $this->view->user_profile["id"];
    $this->view->is_my_profile = ($_SESSION['user']["username"] == $this->view->user_profile['username']);

    if ($this->view->user_profile === NULL) {
      redirect('/NotFound');
    };

    $this->view->comments = array(
      'sum_comments' => count($Comment->findAll()),
      'parent_id' => $user_id,
      'table' => "profile"
    );

    $this->setMeta();
    $tag = get("tag");
    $this->view->articles = $article->findAll();
    $this->view->menu_1 = get("menu_1");
    $this->view->count_articles =  $article->countBy("author = $user_id");
    $this->view->count_likes =  $Like->countBy("user = $user_id");
    $this->view->count_bookmark =  $Bookmark->countBy("user = $user_id");

    if ($tag) {
      $this->view->h1 = "с тегом #$tag";
    }
    $this->setMeta();

    $this->view->setJs('add');
    $this->view->setJs('loadComments');

    $this->view->setCss('icon');

    $this->setCss('index');
    $this->setCss('profile');
    $this->view->setCss('button');
    $this->view->setCss('comments');

    $this->view->display('profile');
  }

  protected function profileEdit($field)
  {
    if (!isLogin()) {
      $errors = array(
        'status'  => 401,
        'message' => "<a href='/login'>Войдите на сайт</a>, чтобы добавлять комментарии!",
        'data' => null,
      );
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    if (empty($_POST[$field])) {
      $errors = array(
        'status'  => 400,
        'message' => "Поле должно быть не пустое!",
        'data' => null,
      );
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    $User = new User();
    $data = $_POST;
    $User->load($data);
    $User->attributes['id'] = $_SESSION['user']['id'];

    $status = $User->edit($field);

    if ($status) {
      $_SESSION['user'][$field] =  $data[$field];
      $message = array(
        'status'  => 200,
        'message' => "Данные изменены",
        'data' => array(
          'field' => $field,
          'value' => $data[$field]
        ),
      );
      echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = array(
        'status'  => 500,
        'message' => "Ошибка! Попробуйте позже",
        'data' => null,
      );
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function loadComments($sort = 'new')
  {
    $id = $_GET['id'];
    $comment = new Comment();
    $comments = $comment->findAllByIdArticle($id, $sort, 'author');
    $comments = json_encode($comments, JSON_UNESCAPED_UNICODE);

    if ($comments) {
      $message = [];
      $message[] = "success";
      $message[] = $comments;
      echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = 'Ошибка! Попробуйте позже';
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
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
    return $this->view->user_profile["username"];
  }

  protected function description()
  {
    return "Профиль пользователя {$this->view->user_profile["username"]} на сайте Indyground.ru";
  }

  protected function keywords()
  {
    return "Indyground, " . $this->view->user_profile["username"];
  }

  protected function author()
  {
    return $this->view->user_profile["username"];
  }
  protected function name_page()
  {
    return "page_profile";
  }
}
