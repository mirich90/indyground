<?php

namespace App;

use App\Meta;

abstract class Controller
{
  protected $view;
  protected $meta;

  public function __construct()
  {
    session_start();
    $this->view = new View();
    $this->meta = new Meta();
  }

  protected function access(): bool
  {
    return true;
  }

  public function __invoke()
  {

    $this->view->is_user = isset($_SESSION['user']);

    if ($this->view->is_user) {
      $this->view->user = $_SESSION['user'];
      $this->view->is_admin = ($_SESSION['user']["role"] == 'admin');
    }

    if ($this->access()) {
      $this->handle();
    } else {
      die('Нет');
    }
  }

  protected function setCss($css)
  {
    $this->view->setCss($css);
  }
  protected function setJs($js, $is_defer = true)
  {
    $this->view->setJs($js, $is_defer);
  }
  protected function setFonts($fonts)
  {
    $this->view->setJs($fonts);
  }

  // пока не рбаотае почему-то. должен выявить был ажакс запрос или нет
  public function isAjax()
  {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
  }

  abstract protected function handle();
  abstract protected function setMeta();
  abstract protected function title();
  abstract protected function description();
  abstract protected function keywords();
  abstract protected function author();
  abstract protected function name_page();
}
