<?
$this->setJs('navbar');
$this->setCss('navbar');
?>

<nav class="nav menu">
    <a href="#content" class="button-scroll-up">^</a>
    <a href="/" class="nav-logo">
        <span>blog_platform</span>
    </a>

    <div class="nav-mobile">
        <div id="nav-toggle">
            <span></span>
        </div>
    </div>

    <ul class="nav-list">

        <li class="nav-item">
            <a href="#!" class="y-dropdown-toggle">Тема</a>
            <ul class="nav-dropdown y-dropdown-menu">
                <li class="nav-dropdown-item theme-switch" data-theme_name="light"><span>Светлая</span></li>
                <li class="nav-dropdown-item theme-switch" data-theme_name="dark"><span>Темная</span></li>
                <li class="nav-dropdown-item theme-switch" data-theme_name="brown"><span>Браун</span></li>
            </ul>
        </li>

        <? if (isShield()) : ?>
            <li class="nav-item">
                <a href="#!" class="y-dropdown-toggle">Создать</a>
                <ul class="nav-dropdown y-dropdown-menu">
                    <li class="nav-dropdown-item"><a href="/createPost">Статьи</a></li>
                    <li class="nav-dropdown-item"><a href="/shortlinks">Короткая ссылка</a></li>
                </ul>
            </li>
        <? endif; ?>

        <li class="nav-item">
            <a href="#!" class="y-dropdown-toggle">Категории</a>
            <ul class="nav-dropdown y-dropdown-menu">
                <li class="nav-dropdown-item"><a href="/index">Все</a></li>
                <? if (isShield()) : ?>
                    <li class="nav-dropdown-item"><a href="/index/?category=1">Код</a></li>
                    <li class="nav-dropdown-item"><a href="/index/?category=2">Графика</a></li>
                    <li class="nav-dropdown-item"><a href="/index/?category=3">Текст</a></li>
                    <li class="nav-dropdown-item"><a href="/index/?category=4">Музыка</a></li>
                    <li class="nav-dropdown-item"><a href="/index/?category=6">Задачи</a></li>
                    <li class="nav-dropdown-item"><a href="/index/?category=5">Прочее</a></li>
                <? endif; ?>
            </ul>
        </li>

        <li class="nav-item">
            <a href="/tasks">Задачи</a>
        </li>

        <? if (isShield()) : ?>

            <li class="nav-item">

                <? if ($this->is_user) : ?>
                    <a href="#!" class="y-dropdown-toggle">
                        <?= $this->user['name'] ?>
                    </a>
                    <ul class="nav-dropdown y-dropdown-menu">
                        <li class="nav-dropdown-item">
                            <a href="/profile">
                                Профиль <?= $this->user['name']; ?>
                            </a>
                        </li>
                        <!-- <li class="nav-dropdown-item"><a href="/messages">Личные сообщения</a></li> -->
                        <!-- <li class="nav-dropdown-item"><a href="/friends">Друзья</a></li> -->
                        <!-- <li class="nav-dropdown-item"><a href="/comments">Комментарии</a></li> -->
                        <li class="nav-dropdown-item"><a href="/profile/?username=<?= $this->user['username'] ?>&menu_1=bookmarks&bookmarks=true">Закладки</a></li>
                        <li class="nav-dropdown-item"><a href="/profile/?username=<?= $this->user['username'] ?>&menu_1=likes&likes=true">Любимое</a></li>
                        <li class="nav-dropdown-item"><a href="settings">Настройки</a></li>
                        <li class="nav-dropdown-item"><a href="/logout">Выйти</a></li>
                    </ul>

                <? else : ?>
                    <a href="/login" class="y-dropdown-toggle">Войти</a>
                <? endif; ?>

            </li>
        <? endif; ?>


        <? if (isShield() && $this->is_admin) : ?>
            <li class="nav-item">
                <a href="#!" class="y-dropdown-toggle">
                    Админ
                </a>
                <ul class="nav-dropdown y-dropdown-menu">
                    <li class="nav-dropdown-item"><a href="/lists/?user">Список пользователей</a></li>
                    <li class="nav-dropdown-item"><a href="/lists/?articles">Список статей</a></li>
                    <li class="nav-dropdown-item"><a href="/lists/?images">Список картинок</a></li>
                    <li class="nav-dropdown-item"><a href="/lists/?comments">Список комментариев</a></li>
                </ul>
            </li>
        <? endif; ?>

        <li><a href="/about">О нас</a></li>
    </ul>
</nav>