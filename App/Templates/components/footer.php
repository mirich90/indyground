<?
$this->setCss('footer');
?>

<footer>

    <? if (isShield()) : ?>

        <div class="container clearfix">
            <ul>
                <li><span>Категории<span></span></span></li>
                <li class="nav-dropdown-item"><a href="/index/?category=1">Код</a></li>
                <li class="nav-dropdown-item"><a href="/index/?category=2">Графика</a></li>
                <li class="nav-dropdown-item"><a href="/index/?category=3">Текст</a></li>
                <li class="nav-dropdown-item"><a href="/index/?category=4">Музыка</a></li>
                <li class="nav-dropdown-item"><a href="/index/?category=5">Прочее</a></li>

            </ul>
            <ul>
                <li><span>Создать<span></span></span></li>
                <li><a href="#0">Статью</a></li>
            </ul>
            <ul>
                <li><span>Мой профиль<span></span></span></li>
                <li class="nav-dropdown-item"><a href="/index/?bookmarks=1">Закладки</a></li>
                <li class="nav-dropdown-item"><a href="/index/?likes=1">Любимое</a></li>
                <li class="nav-dropdown-item"><a href="settings">Настройки</a></li>
                <li class="nav-dropdown-item"><a href="/logout">Выйти</a></li>
            </ul>
        </div>

    <? endif; ?>

    <div class="footer__newsletter_copy">© Дизайн и создание <a href="https://twitter.com">@testname</a> 2022</div>
</footer>