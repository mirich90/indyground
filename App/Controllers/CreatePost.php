<?php

namespace App\Controllers;

use App\Controller;
use App\Errors;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Content;
use App\Models\Image;
use App\Models\User;

class CreatePost extends Controller
{

  public function access(): bool
  {
    if (!isShield()) {
      redirect('/NotFound');
      die;
    }

    if (!isLogin()) {
      $_SESSION['error'] = "Зарегистрируйтесь, чтобы добавлять статьи!";
      redirect('/login');
      die;
    }

    if (!isRole('moderator') && !isRole('admin')) {
      $_SESSION['error'] = "Пока только модераторы или админы могут добавлять статьи!";
      redirect('/NotFound');
      die;
    }
    return true;
  }

  protected function handle()
  {

    if (isset($_POST['creatArticle'])) {
      $this->creatArticle();
      die;
    }
    if (isset($_POST['editArticle'])) {
      $this->editArticle($_POST['editArticle'], $_POST['src']);
      die;
    }
    if (isset($_POST['addImg'])) {
      $this->uploadImg();
      die;
    }
    if (isset($_POST['getGallery'])) {
      $this->getImg();
      die;
    }
    if (hasGet('id')) {
      $article = new \App\Models\Article();
      $this->view->article = $article->findBySrc($_GET['id']);
      $this->view->tags = explode(",", $this->view->article["tags"]);
      $this->view->contents = $this->getContent($this->view->article['id']);
    } else {
      $this->view->contents = 0;
      $this->view->article = [];
    }

    $this->setMeta();
    $this->view->display('createPost');
  }

  protected function getContent($id)
  {
    $Content = new \App\Models\Content();
    $data = $Content->getContent($id);
    foreach ($data as $key => $value) {
      unset($data[$key]['article_id']);
      unset($data[$key]['id']);
      $data[$key]['class'] = '';
      $data[$key]['_isFocus'] = ($key == 0);
      $data[$key]['html'] = strip_tags($data[$key]['html'], '<i><u><b><a>');
      $data[$key]['_html'] = "";
      $data[$key]['_placeholder'] = "Введите текст";
    }
    return json_encode($data, JSON_UNESCAPED_UNICODE);
  }

  protected function createTags($article_id, $tags_list, $author)
  {
    $Tag = new Tag();
    $tags_arr = explode(",", $tags_list);
    foreach ($tags_arr as $name) {
      $data = array();
      $data["name"] = $name;
      $data["article"] = $article_id;
      $data["author"] = $author;
      $Tag->load($data);
      $Tag->save();
    }
  }

  protected function deleteTags($article_id)
  {
    $Tag = new Tag();
    $data = array();
    $data["article"] = $article_id;
    $Tag->delete();
  }

  protected function getImg()
  {
    $image = new Image();
    $id = $_SESSION['user']["id"];
    $images = $image->findAllByAuthor($id);
    if ($images) {
      $message = [];
      $message['status'] = "success";
      $message['text'] = "Получена галлерея пользователя";
      $message['images'] = json_encode($images);
      echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors['status'] = "warning";
      $errors['text'] = "В галлерее пока пусто";
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function uploadImg()
  {
    $image_name = $_POST["imageName"];
    $image_base64 = $_POST["imageFile"];
    $type_file = $this->getExtensionFile($image_base64);
    $name = $this->getNamePath($image_name);

    $isLoad = $this->saveImgInHost($image_base64, $type_file, $name);

    echo $this->saveImgInBd($name, $type_file, $image_name);
  }

  protected function saveImgInBd($name, $filetype, $image_name)
  {
    $image = new Image();
    $data = array();

    $data["name"] = $name;
    $data["original_name"] = h($image_name);
    $data["src"] = "$name.$filetype";
    $data["filetype"] = $filetype;
    $data["author"] = $_SESSION['user']["id"];
    $image->load($data);

    if (!$image->validate($data)) {
      $errors = [];
      $errors[] = "error";
      $errors[] = $image->getErrorsValidate();
      return json_encode($errors, JSON_UNESCAPED_UNICODE);
    }

    $src = $image->save("src");
    if ($src) {
      $message = [];
      $message['status'] = "success";
      $message['text'] = "Загружена картинка '$src'";
      $message['src'] = $src;
      $message['alt'] = $image_name;
      return json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = "Загрузка файла не поддерживается ($filetype)";
      return json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function saveImgInHost($base64, $type_file, $name)
  {
    $is_local = (include __DIR__ . '/../config.php')['is_local'];
    $public_dir = ($is_local) ? 'public' : 'public_html';
    $image_file = $this->decodeImgFromBase64($base64);
    $uploaddir = __DIR__ . "/../../$public_dir/img/load/";
    $uploadpath = $uploaddir . "$name.$type_file";

    $status = file_put_contents($uploadpath, $image_file, LOCK_EX);
    if ($status === false) return false;

    $this->saveImgInWebp($image_file, $uploadpath, $uploaddir, $name);

    return true;
  }

  protected function saveImgInWebp($image_file, $uploadpath, $uploaddir, $name)
  {
    $uploadpath_webp =  $uploaddir . "$name.webp";
    $image_str = imagecreatefromstring($image_file);
    $image_str = $this->setOrientation($image_str, $uploadpath);
    imageWebp($image_str, $uploadpath_webp, 100);
    $this->resizeImg($uploaddir, "$name.webp", 'webp');
    imagedestroy($image_str);
  }

  protected function setOrientation($image_str, $uploadpath)
  {
    $exif = @exif_read_data($uploadpath, 'EXIF');
    if (!empty($exif['Orientation'])) {
      switch ($exif['Orientation']) {
        case 8:
          $image_str = imagerotate($image_str, 90, 0);
          break;
        case 3:
          $image_str = imagerotate($image_str, 180, 0);
          break;
        case 6:
          $image_str = imagerotate($image_str, -90, 0);
          break;
      }
    }
    return $image_str;
  }
  protected function getNamePath($name)
  {
    $path = translitSrc($name);
    return $path;
  }
  protected function getExtensionFile($base64)
  {
    $type_file = explode(';', $base64)[0];
    $type_file = explode('/', $type_file)[1];
    return $type_file;
  }
  protected function decodeImgFromBase64($base64)
  {
    $data = explode(',', $base64)[1];
    $img = base64_decode($data);
    return $img;
  }

  protected function resizeImg($uploaddir, $name, $type)
  {
    header("Content-Type: image/$type");
    $filename = $uploaddir . $name;
    $filename_new = $uploaddir . "min/$name";

    list($width, $height) = getimagesize($filename);
    $needWidth = ($width > $height) ? 240 : 400;
    $percent = round($needWidth / $height, 2);

    $new_width = $width * $percent;
    $new_height = $height * $percent;

    $image_p = imagecreatetruecolor($new_width, $new_height);

    if ($type == "png") {
      $img = imageCreateFromPng($filename);
    } else if ($type == "jpg" || $type == "pjpeg" || $type == "jpeg" || $type == "plain") {
      $img = imageCreateFromJpeg($filename);
    } else if ('webp') {
      $img = imageCreatefromWebp($filename);
    }

    imagecopyresampled($image_p, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imageWebp($image_p, $filename_new, 100);
    imagedestroy($img);
    imagedestroy($image_p);
  }

  protected function createContents($contents, $article_id)
  {
    $Content = new Content();
    $contents = json_decode($contents, true);
    foreach ($contents as $c) {
      $c["article_id"] = $article_id;
      // $c["html"] = json_encode($c["html"], JSON_UNESCAPED_UNICODE);
      $Content->load($c);
      $Content->save();
    }
  }
  protected function deleteContents($article_id)
  {
    $Content = new Content();
    $c["article_id"] = $article_id;
    $Content->load($c);
    $Content->delete();
  }

  protected function getImgBySrc($src)
  {
    if (empty($src)) {
      return null;
    } else {
      $Images = new Image();
      $image = $Images->find(['src'], [$src])['id'];
      return $image;
    }
  }

  protected function creatArticle()
  {
    $article = new Article();
    $data = $_POST;
    $article->load($data);

    if (!$article->validate($data)) {
      $errors = array("status" => "error", "text" => $article->getErrorsValidate());
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    $src = $this->getNamePath($data["title"]);
    $article->attributes['src'] = $src;
    $article->attributes['author'] = $_SESSION['user']["id"];
    $article->attributes['img'] = $this->getImgBySrc($data["img"]);
    $id = $article->save();

    $this->createContents($data["content"], $id);

    $this->createTags(
      $id,
      $article->attributes['keywords'],
      $article->attributes['author']
    );

    if ($id) {
      $message = array("status" => "success", "text" => "Создана <a href='/article/?id=$src'>статья</a>");
      echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = array("status" => "error", "text" => "Ошибка! Попробуте позже");
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function editArticle($id, $src)
  {
    $article = new Article();
    $data = $_POST;
    $article->load($data);

    if (!$article->validate($data)) {
      $errors = array("status" => "error", "text" => $article->getErrorsValidate());
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
      die;
    }

    $article->attributes['id'] = $id;
    $article->attributes['author'] = $_SESSION['user']["id"];
    $article->attributes['img'] = $this->getImgBySrc($data["img"]);

    $status = $article->edit();

    $this->deleteContents($id);
    $this->createContents($data["content"], $id);

    $this->deleteTags($id);
    $this->createTags(
      $id,
      $article->attributes['keywords'],
      $article->attributes['author']
    );
    // $message = array("status" => "success", "text" => $response[0]);
    // echo json_encode($message, JSON_UNESCAPED_UNICODE);
    if ($status) {
      $message = array("status" => "success", "text" => "Создана <a href='/article/?id=$src'>статья</a>");
      echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
      $errors = array("status" => "error", "text" => "Ошибка! Попробуйте позже");
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
    return "page_create_post";
  }
}
