<?
$this->setCss('input');
// $this->view->setCss('alert');
$this->setCss('button');
// $this->view->setCss('icon');
$this->setCss('badges');
$this->setCss('article');
// $this->view->setCss('editor-events');
// $this->view->setCss('editor-body');
$this->setCss('tooltips');
$this->setCss('popup');
$this->setCss('highlighting');

$this->setCss('icon');
$this->setCss('editor');

$this->setJs('editor', false);
$this->setJs('add');
$this->setJs('save');
// $this->view->setJs('createPost');
?>


<div class="container">
  <h1>Редактор</h1>
  <div id="editor"></div>
</div>

<script nonce="NcTAri1XtyB8ZuGIio4C1dVtdtkxdj9YwwKMeJ19J8">
  let content = <?= $this->contents; ?>;
  let editor = new Editor("editor", content);
</script>

<div class="popup popup-article-info">
  <div class="popup-article-info-box popup-box">
    <div class="input__wrapper">
      <label class="label">Заголовок</label>
      <input id="popup-article-info-title" class="input" type="text" placeholder="Введите название статьи" value="<?= (isset($this->article['category'])) ? $this->article['title'] : ""; ?>" />
    </div>

    <div id="popup-article-info-preview">
      <img id="popup-article-info-img" class="big dark flat">
      <button id="popup-article-info-input" class="button">Добавить превью</button>
      <button id="popup-article-info-delete" class="button">Удалить превью</button>
    </div>

    <div class="input__wrapper">
      <label class="label">Описание</label>
      <textarea id="popup-article-info-description" class="textarea" type="text" placeholder="Расскажите, о чем статья" class="no-enter">
        <?= (isset($this->article['category'])) ? $this->article['description'] : ""; ?>
      </textarea>
    </div>

    <? $category = (isset($this->article['category'])) ? $this->article['category'] : 1; ?>

    <div class="input__wrapper">
      <label class="label">Категория</label>
      <select id="popup-article-info-category" class="select" type="text" placeholder="Placeholder">
        <option value="1" <?= ($category == 1) ? 'selected' : ''; ?>>Код</option>
        <option value="2" <?= ($category == 2) ? 'selected' : ''; ?>>Графика</option>
        <option value="3" <?= ($category == 3) ? 'selected' : ''; ?>>Текст</option>
        <option value="4" <?= ($category == 4) ? 'selected' : ''; ?>>Музыка</option>
        <option value="5" <?= ($category == 5) ? 'selected' : ''; ?>>Прочее</option>
      </select>
    </div>

    <div class="input__wrapper">
      <label class="label">Теги</label>
      <input id="popup-article-info-tags" class="input" type="text" name="example" list="exampleList" placeholder="Введите тег, нажмите 'Enter'" />
      <datalist id="exampleList">
        <option value="js"></option>
        <option value="go"></option>
      </datalist>

      <section id="popup-article-info-badges" class="badges">
        <? if (count($this->tags) > 0) : ?>
          <? foreach ($this->tags as $tag) : ?>
            <span class="badge status-lagoon"><?= $tag; ?></span>
          <? endforeach ?>
        <? endif ?>
      </section>
    </div>

    <div class="alert"></div>

    <div id="" class="buttons">

      <?
      if (count($this->article) > 0) {
        echo $this->ui('btn', [
          'text' => 'Редактировать',
          'id' => 'popup-article-info-edit',
          'classes' => 'fill primary maxwidth',
          'data-id' => $this->article['id'],
          'data-src' => $this->article['src']
        ]);
      } else {
        echo $this->ui('btn', [
          'text' => 'Опубликовать',
          'id' => 'popup-article-info-save',
          'classes' => 'fill primary maxwidth'
        ]);
      }
      ?>

      <?= $this->ui('btn', ['text' => 'Отмена', 'classes' => 'fill danger maxwidth cancel']) ?>

    </div>
  </div>
</div>