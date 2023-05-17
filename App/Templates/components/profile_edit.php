<?
$this->setJs('profileEdit');
$tmp = ['user' => $this->user_profile];
?>


<div class="info_edit hidden container-sm">
  <div class="row-space">
    <?= $this->ui('input', [
      'id' => 'name',
      'label' => 'Никнейм',
      'value' => $tmp['user']['name'],
      'placeholder' => 'Введите отображаемый никнейм или ФИО',
    ]); ?>
    <?= $this->ui('btn', ['text' => 'Изменить', 'classes' => 'profile-edit', 'data-id' => 'name']) ?>
  </div>

  <div class="row-space">
    <?= $this->ui('input', [
      'id' => 'login',
      'label' => 'Логин',
      'value' => $this->user_profile['login'],
      'placeholder' => 'Введите логин на английском языке',
    ]); ?>
    <?= $this->ui('btn', ['text' => 'Изменить', 'classes' => 'profile-edit', 'data-id' => 'login']) ?>
  </div>

  <div class="row-space">
    <?= $this->ui('input', [
      'id' => 'username',
      'label' => 'Адрес профиля',
      'value' => $this->user_profile['username'],
      'placeholder' => 'Введите адрес личной страницы на английском языке',
    ]); ?>
    <?= $this->ui('btn', ['text' => 'Изменить', 'classes' => 'profile-edit', 'data-id' => 'username']) ?>
  </div>

  <div class="row-space">
    <?= $this->ui('input', [
      'id' => 'email',
      'label' => 'Email (адрес эл.почты)',
      'value' => $this->user_profile['email'],
      'placeholder' => 'Введите email (адрес эл.почты)',
    ]); ?>
    <?= $this->ui('btn', ['text' => 'Изменить', 'classes' => 'profile-edit', 'data-id' => 'email']) ?>
  </div>

  <div class="row-space">
    <?= $this->ui('input', [
      'id' => 'city',
      'label' => 'Место жительства',
      'value' => $this->user_profile['city'],
      'placeholder' => 'Введите место жительства',
    ]); ?>
    <?= $this->ui('btn', ['text' => 'Изменить', 'classes' => 'profile-edit', 'data-id' => 'city']) ?>
  </div>

</div>