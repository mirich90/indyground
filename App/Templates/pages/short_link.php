<?
$this->setCss('input');
$this->setCss('short_link');
$this->setJs('shortLink');
?>

<div id="shortlink">
    <div class="container">
        <h1> Создать короткую ссылку </h1>

        <div class="shortlink-form">

            <?= $this->ui('input', [
                'id' => 'shortlink-url',
                'label' => 'Ссылка',
                'type' => 'url',
                'placeholder' => "Введите ссылку",
            ]); ?>

            <ul>
                <li>Поле должно содержать минимум 13 символов</li>
            </ul>

            <div class="row-space">
                <?= $this->ui('input', [
                    'id' => 'shortlink-shortcode',
                    'label' => 'Короткий адрес (если поле пустое, будет сгенерирован случайный код.)',
                    'placeholder' => "Введите желаемый короткий адрес",
                ]); ?>

                <?= $this->ui('btn', ['text' => 'Проверить', 'classes' => 'shortlink-shortcode-btn']) ?>
            </div>

            <ul>
                <li>Только английские символы, цифры и знак "-" (разделитель)</li>
                <li>Первый символ всегда начинается с буквы, не с цифры</li>
                <li>Длина от 4 символов включительно</li>
            </ul>

            <div class="wrapper-btns">
                <?= $this->ui('btn', ['id' => 'shortlink-save', 'classes' => 'fill primary', 'text' => 'Создать']) ?>
            </div>

        </div>
    </div>
</div>