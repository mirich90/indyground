<?

namespace App;

class View implements \Countable, \ArrayAccess
{
  protected $data = [];
  protected $css = [];
  protected $js = [];
  protected $fonts = [];

  public function __set($name, $value): void
  {
    $this->data[$name] = $value;
  }

  public function __get($name)
  {
    return $this->data[$name] ?? null;
  }

  public function __isset($name)
  {
    return isset($this->data[$name]);
  }

  public function render($template)
  {
    ob_start();
    include $template;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
  }


  public function display($template, $layout = 'default')
  {
    $head = __DIR__ . "/Templates/layouts/head.php";
    $template = __DIR__ . "/Templates/pages/$template.php";
    $layout = __DIR__ . "/Templates/layouts/$layout.php";

    $this->content = $this->render($template);
    $layout = $this->render($layout);
    $head = $this->render($head);
    echo $head;
    echo $layout;
  }

  public function setCss($css): void
  {
    if (!in_array($css, $this->css)) {
      $this->css[] = $css;
    }
  }

  public function displayCss($name_page): string
  {
    if (!$name_page) {
      return "";
    }

    $is_local = (include __DIR__ . '/config.php')['is_local'];
    $public_dir = ($is_local) ? 'public' : 'public_html';
    $dir =  __DIR__ . "/../$public_dir/mincss";
    $name_file = "$name_page.css";
    $save_file = "$dir/$name_file";
    $file_content = '';

    foreach ($this->css as $value) {
      $file_content .= file_get_contents("$dir/$value.css");
    }

    file_put_contents($save_file, $file_content,  LOCK_EX);

    return "<link rel='stylesheet' href='/mincss/$name_file'>\n";
  }

  public function setFonts($fonts): void
  {
    $this->fonts[] = $fonts;
  }

  public function Component($name, $data = []): void
  {
    $cmp = $data;
    include  __DIR__ . "/Templates/components/$name.php";
  }

  public function Ui($name, $data): void
  {
    $ui = $data;
    include __DIR__ . "/Templates/ui/$name.php";
  }

  public function displayFonts(): string
  {
    $fontLinks = "";
    foreach ($this->fonts as $value) {
      $fontLinks .= "<link href='https://fonts.googleapis.com/icon?family=$value;display=block' rel='stylesheet'>\n";
    }
    return $fontLinks;
  }

  public function setJs($js, $is_defer = true): void
  {
    $this->js[] = [
      'file' => $js,
      'is_defer' => $is_defer,
    ];
  }

  public function displayJs(): string
  {
    $scripts = "";
    foreach ($this->js as $value) {
      $file = $value['file'];
      $defer = ($value['is_defer'] === true) ? 'defer' : '';
      $scripts .= "<script src='/minjs/$file.js' $defer></script>\n";
    }
    return $scripts;
  }

  public function count(): int
  {
    return count($this->data);
  }

  public function offsetSet($offset, $value): void
  {
    $this->data[$offset] = $value;
  }

  public function offsetExists($offset): bool
  {
    return isset($this->data[$offset]);
  }

  public function offsetUnset($offset): void
  {
    unset($this->data[$offset]);
  }

  public function offsetGet($offset)
  {
    return  $this->data[$offset] ?? null;
  }
}
