<?
$this->setCss('input');
$this->setCss('table');
$this->setCss('short_link');
$this->setCss('qr_code');
$this->setJs('qrcode.min');
$this->setJs('shortLink');
?>

<div id="category-new" class="modal-wrapper">
    <div class="modal container">
        <div class="modal-head">
            <p class="modal-title">Создать новую категорию</p>
            <a class="modal-btn-close modal-trigger"></a>
        </div>

        <div class="modal-content">

            <div class="row-space">
                <?= $this->ui('input', [
                    'id' => 'shortlink-category-name',
                    'placeholder' => "Введите название категории",
                ]); ?>

                <?= $this->ui('btn', ['text' => 'Создать', 'classes' => 'shortlink-category-create']) ?>
            </div>
        </div>
    </div>
</div>

<div id="shortlink">
    <div class="container-lg">
        <h1> Создать короткую ссылку </h1>

        <div class="shortlink-form">

            <?= $this->ui('input', [
                'id' => 'shortlink-title',
                'label' => 'Название ссылки',
                'placeholder' => "Введите название/описание ссылки (обязательно)",
            ]); ?>

            <div class="row-space">
                <?= $this->ui('select', [
                    'id' => 'shortlink-category',
                    'label' => "Категория",
                    'placeholder' => "Введите желаемую категорию (необязательно)",
                    'options' => $this->shortlink_categories,
                ]); ?>

                <?= $this->ui('btn', ['text' => 'Создать', 'classes' => 'shortlink-category-new']) ?>
            </div>


            <?= $this->ui('input', [
                'id' => 'shortlink-url',
                'label' => 'Ссылка',
                'type' => 'url',
                'placeholder' => "Введите ссылку (обязательно)",
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


        <h2> Мои ссылки </h2>
        <div class="wrapper-btns">
            <?= $this->ui('btn', [
                'text' => 'Красивый дизайн сайта',
                'id' => 'popup-article-info-edit',
                'classes' => 'small',
                'data-src' => ''
            ]); ?>
            <?= $this->ui('btn', [
                'text' => 'Фильмы',
                'id' => 'popup-article-info-edit',
                'classes' => 'small',
                'data-src' => ''
            ]); ?>
        </div>

        <? if ($this->shortlinks) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Ссылка</th>
                        <th>Короткая ссылка</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($this->shortlinks as $shortlink) : ?>
                        <tr>
                            <td><?= $shortlink["title"] ?></td>
                            <td><?= $shortlink["category_id"] ?></td>

                            <td>
                                <a href=" <?= getUrl() . '/l/' . $shortlink["short_url"] ?>">
                                    <?= getUrl() . '/l/' . $shortlink["short_url"] ?>
                                </a>
                            </td>

                            <td>
                                <a href="<?= $shortlink["original_url"] ?>">
                                    <?= $shortlink["original_url"] ?>
                                </a>
                            </td>
                        </tr>
                    <? endforeach ?>
                </tbody>
            </table>

        <? else : ?>
            <p>Ссылок пока нет.</p>
        <? endif ?>
    </div>
</div>