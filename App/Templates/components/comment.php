<?
$this->setJs('loadComments');

$this->setCss('input');
$this->setCss('comments');
?>

<section id="comment-form">
  <section class="section container">
    <h2 class="section-title">Добавить комментарий</h2>
    <br>
    <cite class="section-left"></cite>
    <div>
      <div class="wrapper__row">
        <textarea type="text" name="textComment" id="textComment" class="textarea" rows=" 3" placeholder="Текст" class=" " autocomplete="off" required=""></textarea>
      </div>


      <div class="alert status-error hidden"></div>
      <div class="alert status-success hidden"></div>
      <br>
      <div class="input__row">
        <?= $this->ui('btn', ['text' => 'Отправить', 'id' => 'createComment', 'classes' => 'primary small', 'data-id' => $this->article['id']]); ?>
      </div>
  </section>
</section>