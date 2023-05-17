<?
$this->setJs('tasks', false);
$this->setCss('tasks');
?>

<div class="dashboard container-lg">
  <div class="header">
    <h1>Задачи</h1>
    <input type="checkbox" id="dashboard-setting-1" name="dashboard-setting-1" value="Bike">
    <label for="dashboard-setting-1">Скрыть списки подзадач</label><br>
    <input type="checkbox" id="dashboard-setting-2" name="dashboard-setting-2" value="Bike">
    <label for="dashboard-setting-3">Показать только назначенные на меня</label><br>
  </div>
  <div class="wrapper-btns">
    <?
    $categories = ['Все', 'Главная страница', 'Редактор', 'Комментарии', '+'];
    foreach ($categories as $category) {
      $this->ui('btn', ['text' => $category, 'classes' => 'small']);
    }

    ?>
  </div>
  <div class="row">
    <div class="header-title">
      <h2 class="col-header start">Созданы</h2>
      <select name="hero[]">
        <option value="1" selected="selected">дате</option>
        <option value="2">приоритету</option>
        <option value="3">исполнителю</option>
      </select>
    </div>
    <div class="header-title">
      <h2 class="col-header progress">В процессе</h2>
      <select name="hero[]">
        <option value="2">приоритету</option>
        <option value="3">исполнителю</option>
      </select>
    </div>
    <div class="header-title">
      <h2 class="col-header done">Готовы</h2>
      <select name="hero[]">
        <option value="2">приоритету</option>
        <option value="3">исполнителю</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="placeholder placeholder-start" data-status="start">
      <?= $this->ui('btn', ['text' => 'Добавить задачу', 'classes' => 'add-task small']); ?>
    </div>
    <div class="placeholder placeholder-progress" data-status="progress">
    </div>
    <div class="placeholder placeholder-done" data-status="done">
    </div>
  </div>

</div>
</section>
<script nonce="NcTAri1XtyB8ZuGIio4C1dVtdtkxdj9YwwKMeJ19J8">
  let tasks = <?= $this->tasks; ?>;
  let Task = startTask(tasks);
</script>