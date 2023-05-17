<div class="container-lg card">
  <div class="card__header">
    <div class="card__profile">
      <?php $image = ($this->user_profile["ava"]) ? "avatars/" . $this->user_profile["ava"] : 'static/ava.png'; ?>
      <img src="/img/<?= $image; ?>" alt="<?= $this->user_profile['name']; ?>" />
    </div>
    <div class="card__name">
      <h2 class="card__profile_name"><?= $this->user_profile['name']; ?></h2>
      <div class="card__handle">
        <span>@
          <span class="card__profile_username"><?= $this->user_profile['username']; ?></span>
        </span>
        <span class="circle"></span>
        <span class="card__profile_city"><?= $this->user_profile['city']; ?></span>
      </div>
    </div>
    <div class="card__button">
      <? if ($this->is_my_profile) : ?>
        <?= $this->ui('btn', ['text' => 'Редактировать', 'classes' => 'profile_edit_btn primary small']) ?>
      <? else : ?>
        <?= $this->ui('btn', ['text' => 'Инфо', 'classes' => 'primary small']) ?>
      <? endif; ?>
    </div>
  </div>

  <? if ($this->is_my_profile) $this->Component('profile_edit'); ?>

  <div class="card__description">
    <p>Текст о себе - какой я хороший, чем знаменит, что делаю, чем занимаюсь. Мои хобби, успехи, достижения. Можно сочинение о себе накатать. Настроить можно в профиле. Далее лорем-текст. Далеко-далеко, за словесными горами в стране гласных и согласных живут рыбные тексты. Скатился, ему курсивных свое родного пор рыбными домах пояс решила.</p>
  </div>

  <div class="card__insights">
    <div class="card__heading">
      <div class="heading">Активности</div>
      <div class="date">
        Май 24 - Декабрь 24
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
          <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
      </div>
    </div>
    <div class="insights">
      <? $this->Component('profile_card', [
        'url' => "/profile/?username=" . $this->user_profile['username'] . "&menu_1=articles",
        'text' => 'Статьи',
        'name' => 'articles',
        'num' => '25',
        'count' => '2',
      ]); ?>
      <? $this->Component('profile_card', [
        'url' => "/profile/?username=" . $this->user_profile['username'] . "&menu_1=games",
        'text' => 'Игры',
        'name' => 'games',
        'num' => '25',
        'count' => '2',
      ]); ?>
      <? $this->Component('profile_card', [
        'url' => "/profile/?username=" . $this->user_profile['username'] . "&menu_1=graphics",
        'text' => 'Графика',
        'name' => 'graphics',
        'num' => '25',
        'count' => '23',
      ]); ?>
      <? $this->Component('profile_card', [
        'url' => "/profile/?username=" . $this->user_profile['username'] . "&menu_1=codes",
        'text' => 'Плагины',
        'name' => 'codes',
        'num' => '25',
        'count' => '12',
      ]); ?>

    </div>
  </div>
</div>

<main class="profile__main">

  <? if ($this->menu_1 === "created" || !$this->menu_1) : ?>

    <nav class="container-lg" aria-label='nav'>
      <ul class="navlinks">
        <li class="link__item">Все</li>
        <li class="link__item">Статьи</li>
        <li class="link__item">Игры</li>
        <li class="link__item">Графика</li>
        <li class="link__item">Музыка</li>
        <li class="link__item">Тексты</li>
        <li class="link__item">Код</li>
      </ul>
    </nav>
    <? $this->Component('articles'); ?>

  <? elseif ($this->menu_1 === "comments") : ?>

    <? $this->Component('comments'); ?>

  <? elseif ($this->menu_1 === "bookmarks") : ?>

    <nav class="container-lg" aria-label='nav'>
      <ul class="navlinks">
        <li class="link__item">Все</li>
        <li class="link__item">Статьи</li>
        <li class="link__item">Игры</li>
        <li class="link__item">Графика</li>
        <li class="link__item">Музыка</li>
        <li class="link__item">Тексты</li>
        <li class="link__item">Код</li>
      </ul>
    </nav>
    <? $this->Component('articles'); ?>

  <? elseif ($this->menu_1 === "likes") : ?>

    <nav class="container-lg" aria-label='nav'>
      <ul class="navlinks">
        <li class="link__item">Все</li>
        <li class="link__item">Статьи</li>
        <li class="link__item">Игры</li>
        <li class="link__item">Графика</li>
        <li class="link__item">Музыка</li>
        <li class="link__item">Тексты</li>
        <li class="link__item">Код</li>
      </ul>
    </nav>
    <? $this->Component('articles'); ?>

  <? endif; ?>
</main>