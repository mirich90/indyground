<?php
// for div add class 'spoiler', for hidden div add class 'spoiler-content' 
// add array content
$num_subtitle = 1;

$this->setJs('spoiler');

$this->setCss('plan');
$this->setCss('spoiler');
?>

<div id="article-plan" class="spoiler">
  <h2 class="article-plan-title">Содержание</h2>
  <div class="spoiler-content">

    <ul>

      <? foreach ($this->contents as $key => $content) : ?>

        <?php if ($content['tag'] == 'h2') : ?>
          <li>
            <a href="#article-subtitle-<?= $num_subtitle++ ?>"><?= $content['html'] ?></a>
          </li>
        <? endif ?>

      <? endforeach ?>

    </ul>
  </div>
</div>