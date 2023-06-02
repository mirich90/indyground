<?
$this->setCss('input');
$this->setCss('generator_card');
$this->setJs('html2canvas.min');
$this->setJs('generatorCard');
?>

<div id="card-generator" class="modal-wrapper">
    <div class="modal modal-lg container">
        <div class="modal-head">
            <p class="modal-title">Генератор карточек</p>
            <a class="modal-btn-close modal-trigger"></a>
        </div>

        <div id="card-generator-preview">
            <div id="card-generator-preview-wrapper">
                <div id="card-generator-preview-card">
                    <h2 id="card-generator-preview-title">
                        Заголовок
                    </h2>

                    <p id="card-generator-preview-text">
                        Текст
                    </p>

                    <div class="wrapper-btns wrapper-btns-right">
                        <?= $this->ui('btn', ['id' => 'card-generator-preview-link', 'text' => 'Подробнее']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="card-generator-content" class="modal-content">

            <div id="card-generator-setting">
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

                <?= $this->ui('select', [
                    'id' => 'generator-type',
                    'type' => 'file',
                    'label' => "Выберите шаблон карточки",
                    'options' => [
                        [
                            'value' => 'image',
                            'text' => 'С картинкой'
                        ],
                        [
                            'value' => 'type_1',
                            'text' => 'Дизайн 1'
                        ],
                    ],
                ]); ?>

                <?= $this->ui('input', [
                    'id' => 'generator-img',
                    'type' => 'file',
                    'label' => "Выберите фоновую картинку",
                ]); ?>

                <div class="wrapper-btns">
                    <?= $this->ui('btn', ['id' => 'card-generator-save', 'text' => 'Скачать']) ?>
                    <?= $this->ui('btn', ['id' => 'card-generator-tamplate', 'text' => 'Сохранить шаблон']) ?>
                </div>
            </div>

        </div>
    </div>
</div>