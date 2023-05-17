<?
$this->setCss('gallery_games');
?>

<section class="section-gallery_games container-lg">
    <div class="section-gallery_games-preview" href="/categories?section=logo-identity">

        <div class="section-gallery_games__image">
            <img src="/img/test/6.PNG" title="Logo &amp; branding design" alt="Logo &amp; branding design">
        </div>

        <div class="section-gallery_games__image_list">
            <img src="/img/test/7.PNG" title="Logo &amp; branding design" alt="Logo &amp; branding design">
        </div>
        <div class="section-gallery_games__image_list section-gallery_games__image_list_2">
            <img src="/img/test/8.PNG" title="Logo &amp; branding design" alt="Logo &amp; branding design">
        </div>

        <?= $this->Component('user', [
            'url' => "/profile/?username=qwe",
            'text' => "Yuryol",
            'img-src' => "/img/avatars/test.png",
            "bg" => 'color-primary',
            "classes" => "section-gallery_games-author"
        ]); ?>

        <div class="section-gallery_games__carousel">
            <div class="section-gallery_games__carousel-steps " data-carousel-steps="">
                <div data-carousel-step="1"></div>
                <div data-carousel-step="2"></div>
                <div data-carousel-step="3"></div>
                <div data-carousel-step="4" data-carousel-active="true"></div>
            </div>
        </div>

    </div>

    <div class="section-gallery_games-header">
        <h2 class="section-gallery_games-header-title">Для живых</h2>

        <h3 class="section-gallery_games-header-description">Доктор-генетик попадает в тюрьму за убийство, которое он не совершал. Во время нападения пресловутых зомбарей ему удается выбраться из тюрьмы благодаря обитающей в тюрьме крысе. Только помогая друг другу они смогут выбраться оттуда живыми.</h3>

        <?= $this->Component('tags', [
            'tags' => ["Постапокалипсис", "Шутер", "Хоррор"],
            'classes' => "section-gallery_games-header-tags",
            'type' => "tags-grey",
        ]); ?>

        <a href="/" class="section-gallery_games-raiting-title">Рейтинг игры: 79% (7 отзывов)</a>

        <div class="section-gallery_games-raitings">
            <?= $this->ui('diagram', ['text' => 'Отправить', 'value' => '82', 'classes' => '']); ?>
            <?= $this->ui('diagram', ['text' => 'Отправить', 'value' => '63', 'classes' => 'ui-diagram-peach']); ?>
            <?= $this->ui('diagram', ['text' => 'Отправить', 'value' => '94', 'classes' => 'ui-diagram-cyan']); ?>
            <?= $this->ui('diagram', ['text' => 'Отправить', 'value' => '74', 'classes' => 'ui-diagram-blue']); ?>
            <?= $this->ui('diagram', ['text' => 'Отправить', 'value' => '81', 'classes' => 'ui-diagram-violet']); ?>

        </div>



        <a href="/" class="section-gallery_games-header-all">Посмотреть все игры</a>
    </div>


</section>