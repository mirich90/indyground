<?
$this->setCss('input');
$this->setCss('generator_card');
$this->setJs('generatorCard');
?>

<div id="card-generator" class="modal-wrapper">
    <div class="modal modal-lg">
        <div class="modal-head">
            <p class="modal-title">Ссылки на статью</p>
            <a class="modal-btn-close modal-trigger"></a>
        </div>
        <div id="card-generator-content" class="modal-content">

            <?= $this->ui('input', [
                'id' => 'generator-title',
                'label' => 'Заголовок (необязательно)',
                'placeholder' => "Введите название карточки",
            ]); ?>

            <?= $this->ui('input', [
                'id' => 'generator-text',
                'label' => 'Текст',
                'placeholder' => "Введите текст карточки",
            ]); ?>

            <?= $this->ui('input', [
                'id' => 'generator-img',
                'type' => 'file',
                'label' => "Выберите фоновую картинку",
            ]); ?>
        </div>
    </div>
</div>