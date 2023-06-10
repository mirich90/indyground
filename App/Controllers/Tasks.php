<?php

namespace App\Controllers;

use App\Controller;

use App\Models\User;
use App\Models\Task;
use App\Models\Subtask;

class Tasks extends Controller
{
  public function access(): bool
  {
    if (!empty($_POST["edit"])) {
      $this->edit($_POST);
      die;
    }
    if (!empty($_POST["newsubtask"])) {
      $this->addSubtask($_POST);
      die;
    }
    if (!empty($_POST["subtask"])) {
      $this->setSubtask($_POST);
      die;
    }
    if (!empty($_POST["add"])) {
      $this->add($_POST);
      die;
    }
    return true;
  }

  protected function handle()
  {
    $Task = new Task;
    $User_profile = new User;
    $username = isset($_GET['username']) ?: $_SESSION['user']["username"];
    $this->view->user_profile = $User_profile->findAllBy("username", $username)[0];
    $user_id = $this->view->user_profile["id"];
    $this->view->tasks = $Task->findAllByAuthor($user_id);

    $this->setMeta();


    $this->view->display('tasks');
  }

  protected function setSubtask()
  {

    $data = $_POST;
    $Subtask = new Subtask();
    $Subtask->load($data);
    $Subtask->attributes['user_id'] = $_SESSION['user']["id"];
    $Subtask->attributes['id'] = $_POST["id"];

    if ($Subtask->attributes['user_id'] == '') {
      $_SESSION['message'] = "Зарегистрируйтесь, чтобы создавать и редактировать задачи!";
      echo json_encode(array(
        'user' => 0
      ));
      die;
    }

    $status = $Subtask->update();

    if ($status) {
      echo json_encode(array(
        'status' => 200,
        'message' => 'Подзадача отредактирована',
      ), JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = 'Ошибка! Попробуйте позже';
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }
  protected function addSubtask()
  {
    $data = json_decode($_POST["subtask"], true);
    $Subtask = new Subtask();
    $Subtask->load($data);
    $Subtask->attributes['user_id'] = $_SESSION['user']["id"];
    $Subtask->attributes['task_id'] =  $_POST["task_id"];
    if ($Subtask->attributes['user_id'] == '') {
      $_SESSION['message'] = "Зарегистрируйтесь, чтобы создавать и редактировать задачи!";
      echo json_encode(array(
        'user' => 0
      ));
      die;
    }
    $id = $Subtask->insert();

    if ($id) {
      $data = $Subtask->findById($id);
      echo json_encode(array(
        'status' => 200,
        'id' => $id,
        'data' => $data,
      ), JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = 'Ошибка! Попробуйте позже';
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function add()
  {
    $data = json_decode($_POST["task"], true);
    $Task = new Task();
    $Task->load($data);
    $Task->attributes['user'] = $_SESSION['user']["id"];
    $Task->attributes['worker_id'] = $_SESSION['user']["id"];
    $Task->attributes['author'] = $_SESSION['user']["id"];

    if ($Task->attributes['user'] == '') {
      $_SESSION['message'] = "Зарегистрируйтесь, чтобы создавать и редактировать задачи!";
      echo json_encode(array(
        'user' => 0
      ));
      die;
    }

    $id = $Task->insert();

    if ($id) {
      $data = $Task->findById($id);
      echo json_encode(array(
        'status' => 200,
        'id' => $id,
        'data' => $data,
      ), JSON_UNESCAPED_UNICODE);
    } else {
      $errors = [];
      $errors[] = "error";
      $errors[] = 'Ошибка! Попробуйте позже';
      echo json_encode($errors, JSON_UNESCAPED_UNICODE);
    }
  }

  protected function edit()
  {
    $data = json_decode($_POST["task"], true);
    $Task = new Task();
    $Task->load($data);
    $Task->attributes['user'] = $_SESSION['user']["id"];
    $Task->attributes['id'] = $data['id'];

    if ($Task->attributes['user'] == '') {
      $_SESSION['message'] = "Зарегистрируйтесь, чтобы создавать и редактировать задачи!";
      echo json_encode(array(
        'user' => 0
      ));
      die;
    }

    $id = $Task->update();

    if ($id) {
      echo json_encode(array(
        'status' => $id
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
    return "tasks";
  }
}
