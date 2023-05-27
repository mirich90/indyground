<?

$this->setJs('add');

$this->setCss('icon');
$this->setCss('button');
$this->setCss('alert');
$this->setCss('article');
$this->setCss('highlighting');
?>

<? $this->Component('article_header'); ?>

<div class="container">

  <? $this->Component('article_action'); ?>

  <div class="description container-plus">
    <p><?= $this->article['description'] ?></p>
    <div class="dop-info">
      <cite><?= $this->article['datetime'] ?></cite>
      <cite>время чтения: 4 мин.</cite>
    </div>
  </div>

  <? $this->Component('plan'); ?>
  <? $this->Component('article_content'); ?>
</div>

<? $this->Component('comment'); ?>
<? $this->Component('comments'); ?>