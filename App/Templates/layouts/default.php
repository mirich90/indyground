<?
$this->setCss('reset');
$this->setCss('root');
$this->setCss('style');
?>

<body>
  <? $this->Component('nav') ?>

  <div class="progress-container">
    <div class="progress-bar" id="myBar" style="width: 0%;"> </div>
  </div>

  <!-- <div class="center">
    <div class="preloader"></div>
  </div> -->

  <section id="content">
    <?= $this->content; ?>
  </section>

  <? $this->Component('modal'); ?>
  <? $this->Component('footer'); ?>

</body>

</html>