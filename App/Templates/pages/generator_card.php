<div class="container-lg">
    <h1>Генератор карточек</h1>
    <br>

    <?= $this->ui('btn', ['text' => 'Создать карточку', 'classes' => 'create-card fill primary']) ?>

    <?= $this->Component('generator_card'); ?>
</div>