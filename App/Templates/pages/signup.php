<div class="container-sm">
  <h1>Регистрация</h1>

  <form action="/signup" method="post">

    <div class="input__wrapper">
      <label class="label__form" for="email">Email</label>
      <input type="text" name="email" id="email" placeholder="Введите пароль" autocomplete="off" value="<?= ss('form_data', 'email', true) ?>" class="input">
    </div>
    <!-- <div class="input__wrapper">
      <label class="label__form" for="login">Логин</label>
      <input type="text" name="login" id="login" placeholder="Введите логин" autofocus autocomplete="off" value="<?= ss('form_data', 'login', true) ?>" class="input">
    </div> -->

    <div class="input__wrapper">
      <label class="label__form" for="password">Пароль</label>
      <input type="password" name="password" id="password" placeholder="Введите пароль" autocomplete="off" class="input">
    </div>

    <!-- <div class="input__wrapper">
      <label class="label__form" for="name">Имя</label>
      <input type="text" name="name" id="name" placeholder="Введите Имя" autocomplete="off" value="<?= ss('form_data', 'name', true); ?>" class="input">
    </div> -->


    <?php if (isset($_SESSION['error'])) : ?>
      <div class="alert status-error">
        <?= $_SESSION['error'];
        unset($_SESSION['error']) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])) : ?>
      <div class="alert status-success">
        <?= $_SESSION['success'];
        unset($_SESSION['success']) ?>
      </div>
    <?php endif; ?>

    <div class="buttons">
      <div>
        <button type="submit" class="button medium">Зарегистрироваться</button>
        <a href="/login">Уже есть аккаунт?</a>
      </div>
    </div>

  </form>
</div>