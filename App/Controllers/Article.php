<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Comment;

// use App\Controllers\Article as ControllersArticle;

class Article extends Controller
{

  public function access(): bool
  {
    if (isset($_POST['createComment'])) {
      $this->createComment();
      die;
    } else if (isset($_POST['loadComments'])) {
      $this->loadComments($_POST['sort']);
      die;
    } else if (!empty($_POST)) {
      $this->add();
      die;
    }
    // return isset($_GET['role']) && 'admin' == $_GET['role'];
    return true;
  }

  protected function handle()
  {
    $article = new \App\Models\Article();

    $this->view->article = $article->findBySrc($_GET['id']);

    if ($this->view->article === null) {
      redirect('/NotFound');
    };

    $this->view->contents = $this->getContents();

    $this->view->comments = array(
      'sum_comments' => $this->view->article['sum_comments'],
      'parent_id' => $this->view->article['id'],
      'table' => "article"
    );
    // $content_array = $Content->getContent($_GET['id']);    
    // $this->view->content = $this->getContent($content_array);
    $this->setMeta();

    $this->view->display('article');
  }

  protected function getContents()
  {
    $Content = new \App\Models\Content();
    $data = $Content->getContent($this->view->article['id']);

    foreach ($data as $key => $value) {
      // if ($data[$key]['tag'] === "table") {
      //   $table = json_decode($data[$key]['html'], true);
      //   $alt = $data[$key]['alt'];
      //   $tr = "";
      //   foreach ($table as $key => $value) {
      //       $th = "";
      //       foreach ($table[$key] as $k => $value) {
      //         if ($key === 0){
      //           $th .= "<th>$value</th>";
      //         } else{
      //           $th .= "<td>$value</td>";
      //         }
      //       }
      //     $tr .= "<tr>$th</tr>";
      //   }
      //   $html ="<table>
      //     <caption>$alt</caption>
      //     <tbody>
      //       $tr
      //     </tbody>
      //   </table>";
      // } else {
      $data[$key]['html'] = strip_tags($data[$key]['html'], '<i><u><b><a>');
    }
    return $data;
  }

  protected function loadComments($sort = 'new')
  {
    $id = $_GET['id'];
    $comment = new Comment();
    $comments = $comment->findAllByIdArticle($id, $sort);
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

  protected function createComment()
  {
    if (!isLogin()) {
      $errors = [];
      $errors[] = "error";
      $errors[] = "<a href='/login'>Войдите на сайт</a>, чтобы добавлять комментарии!";
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    if (!isRole('moderator') && !isRole('admin')) {
      $errors = [];
      $errors[] = "error";
      $errors[] = "Пока только модераторы или админы могут добавлять комментарии!";
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    $comment = new Comment();
    $data = $_POST;
    $comment->load($data);

    if (!$comment->validate($data)) {
      $errors = [];
      $errors[] = "error";
      $errors[] = $comment->getErrorsValidate();
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    $comment->attributes['author'] = $_SESSION['user']["id"];
    $comment->attributes['article_id'] = $_GET['id'];
    $id = $comment->save();
    $comments = $comment->findAllByIdArticle($_GET['id']);
    $comments = json_encode($comments, JSON_UNESCAPED_UNICODE);

    if ($id) {
      $message = [];
      $message[] = "success";
      $message[] = "Опубликован комментарий";
      $message[] = $comments;
      echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = 'Ошибка! Попробуйте позже';
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function add()
  {
    $data = $_POST;
    $like = ($data['action'] == 'likes') ? new Like() : new Bookmark();
    $like->load($data);
    $like->attributes['user'] = $_SESSION['user']["id"];

    if ($like->attributes['user'] == '') {
      $_SESSION['message'] = "Зарегистрируйтесь, чтобы добавлять в 'избранное' и 'закладки'!";
      echo json_encode(array(
        'user' => 0
      ));
      die;
    }

    $id = $like->add();

    if ($id) {
      $likes = $like->getCount();
      $sum = $likes[0]->sum;
      $isLike = $likes[0]->is_state;
      echo json_encode(array(
        0 => 'success',
        'state' => $isLike,
        'count' => $sum
      ), JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = 'Ошибка! Попробуйте позже';
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function setMeta()
  {
    $this->meta->name_page = $this->name_page();
    $this->meta->title = $this->title();
    $this->meta->description = $this->description();
    $this->meta->keywords = $this->keywords();
    $this->meta->author = $this->author();
    $this->meta->image = getImagePreview(
      $this->view->article['image'],
      $this->view->article['image_type']
    )[1];
    $this->view->meta = $this->meta;
  }

  protected function title()
  {
    return $this->view->article['title'];
  }

  protected function description()
  {
    return $this->view->article['description'];
  }

  protected function keywords()
  {
    return $this->view->article['keywords'];
  }

  protected function author()
  {
    return $this->view->article['username'];
  }

  protected function name_page()
  {
    return "page_article";
  }
}
