<div class="container-sm">

  <h1>Войти</h1>

  <form action="/login" method="post">

    <div class="input__wrapper">
      <label class="label__form" for="email">Email</label>
      <input type="text" name="email" id="email" placeholder="Введите email" autofocus autocomplete="off" value="<?= ss('form_data', 'email', true) ?>" class="input">
    </div>

    <div class="input__wrapper">
      <label class="label__form" for="password">Пароль</label>
      <input type="password" name="password" id="password" placeholder="Введите пароль" autocomplete="off" class="input">
    </div>



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
        <button type="submit" class="button medium">Войти</button>
        <a href="/signup">Нет аккаунта? Перейти на страницу регистрации</a>
      </div>
    </div>

  </form>
</div>