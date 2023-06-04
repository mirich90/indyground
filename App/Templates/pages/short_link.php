<?
$this->setCss('input');
$this->setCss('short_link');
$this->setCss('qr_code');
$this->setJs('qrcode.min');
$this->setJs('shortLink');
?>

<div id="shortlink">

    <div class="container">
        <h1> Создать короткую ссылку </h1>

        <div class="shortlink-form">

            <?= $this->ui('input', [
                'id' => 'shortlink-title',
                'label' => 'Название ссылки (обязательно)',
                'placeholder' => "Введите название/описание ссылки",
            ]); ?>

            <?= $this->ui('input', [
                'id' => 'shortlink-url',
                'label' => 'Ссылка (обязательно)',
                'type' => 'url',
                'placeholder' => "Введите ссылку",
            ]); ?>

            <div class="row-space">
                <?= $this->ui('input', [
                    'id' => 'shortlink-shortcode',
                    'label' => 'Короткий адрес (если поле пустое, будет сгенерирован случайный код)',
                    'placeholder' => "Введите желаемый короткий адрес",
                ]); ?>

                <?= $this->ui('btn', ['text' => 'Проверить', 'classes' => 'shortlink-shortcode-btn']) ?>
            </div>

            <ul>
                <li>Только английские символы, цифры и знак "-" (разделитель)</li>
                <li>Длина от 4 символов</li>
            </ul>

            <div class="wrapper-btns">
                <?= $this->ui('btn', ['id' => 'shortlink-save', 'classes' => 'fill primary', 'text' => 'Создать']) ?>
            </div>

        </div>
    </div>
</div>