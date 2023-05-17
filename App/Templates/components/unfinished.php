<?
$this->setCss('unfinished');
?>

<section class="section-unfinished container-lg">
    <div class="section-unfinished-article container">
        <h4 class="section-unfinished-article-title">Редактируем абзац</h4>

        <p>
            Разделите на абзацы. Видите сплошной блок текста более восьми строк — разрежьте на абзацы, станет проще читать. Маленький кусочек текста проще заглотить, чем большое блюдо целиком. Текст без деления на абзацы подавляет своей массой.
        </p>
        <p>
            Статью не прочитают, если весь текст свален в один абзац. Читателю нужны остановки для отдыха и осмысления прочитанного
        </p>
        <p>
            Используйте модульный принцип. Задачу читателя нередко решает отдельный блок статьи: одни вещи читателю уже понятны, другие не имеют сейчас значения. Иногда проблему снимает единственный абзац с ясно данным определением или инструкцией к действию.
        </p>
    </div>

    <div class="section-unfinished-card">
        <div class="section-unfinished-card-content">
            <h2 class="section-unfinished-card-title">Получите полный урок</h2>
            <h3 class="section-unfinished-card-description">Зарегистрируйтесь сейчас, чтобы прочитать полный урок и получить доступ к библиотеке из 49 публикаций только для участников, которые обновляются каждую неделю.</h3>
            <div class="wrapper-btns">
                <?= $this->ui('btn', ['text' => 'Узнать больше', 'classes' => 'primary small']) ?>
                <?= $this->ui('btn', ['text' => 'Прочитать', 'classes' => 'fill primary small']) ?>
            </div>
        </div>
        <div class="section-unfinished-card-picture">
            <picture class="section-unfinished-card-picture-wrapper">
                <img src="/img/test/9.PNG" alt="">

            </picture>
        </div>
    </div>
</section>