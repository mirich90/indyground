<?
$this->setCss('recent');
?>

<div class="timeline container-lg">
    <h2>Последние действия</h2>

    <ul class="timeline__items" data-items="">
        <li class="timeline__item timeline__item--in">
            <time class="timeline__item-time" datetime="2023-04-02">Апрель 2, 2023</time>
            <a class="timeline__item-link" href="#">
                <h3>Возрождаю "Для живых"</h3>
            </a>
            <?= $this->ui('img', ['name' => 'Для живых', 'classes' => 'timeline__item-img', 'src' => '/img/test/6.PNG']) ?>
            <small class="timeline__item-pub">Перед разработчиками Dragon Age: Origins из студии Bioware стояла непростая задача. Их прошлые фэнтезийные игры с богатой предысторией базировались на настольной ролевой игре Dungeons & Dragons — к началу 2000-х она уже была хорошо знакома многим игрокам, благодаря чему основные положения Baldur’s Gate и Neverwinter Nights не требовали пояснений. Dragon Age же делалась без опоры на существующие произведения — одной игрой разработчики должны были создать у игроков исчерпывающее представление о мире, в котором те оказались впервые.</small>
        </li>


        <li class="timeline__item timeline__item--in">
            <time class="timeline__item-time" datetime="2023-04-02">Апрель 2, 2023</time>
            <a class="timeline__item-link" href="#">
                <h3>Немного планов</h3>
            </a>
            <small class="timeline__item-pub">По-настоящему серьезный пространственный диссонанс возникает, когда игра проходит первую сюжетную отметку и игрок прибывает в Скайхолд. Dragon Age Inquisition предоставляет игроку огромную крепость, которую на протяжении игры можно не только полностью исследовать, но и реконструировать и оформить согласно своим сюжетным воззрениям.</small>
        </li>

        <li class="timeline__item timeline__item--in">
            <time class="timeline__item-time" datetime="2023-04-02">Апрель 2, 2023</time>
            <a class="timeline__item-link" href="#">
                <h3>О аномалиях</h3>
            </a>
            <small class="timeline__item-pub">В Доме, где ничего никогда не стоит на месте, где в каждом углу может поджидать опасность или аномалия, с которой человеческий разум просто не в силах совладать, не впав в безумие, только туалеты всегда остаются простыми, понятными и последовательными. Они дают игроку необходимый ориентир, контраст, землю под ногами, чтобы тот осознал, в насколько невероятном месте он на самом деле оказался.</small>
        </li>
    </ul>
</div>