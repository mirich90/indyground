<div class="info-action">

    <?= $this->Component('qr_code'); ?>

    <div class="info-action-wrapper">
        <div class="icon action <?= ($this->article['like'] != 1) ? 'noactive' : ''; ?>" data-id="<?= $this->article['id'] ?>" data-table="articles" data-action="likes">
            <p> <?= $this->article['sum_likes']; ?> </p>
            <i class="material-icons"> favorite </i>
        </div>

        <div class="icon action <?= ($this->article['bookmark'] != 1) ? 'noactive' : ''; ?>" data-id="<?= $this->article['id'] ?>" data-table="articles" data-action="bookmarks">
            <p> <?= $this->article['sum_bookmarks']; ?> </p>
            <i class="material-icons"> bookmark </i>
        </div>

        <a href="#comments" class="icon noactive">
            <p> <?= $this->article['sum_comments']; ?> </p>
            <i class="material-icons"> comment </i>
        </a>

        <div class="nav-item menu">
            <div class="icon action noactive y-dropdown-toggle">
                <i class="material-icons"> menu </i>
            </div>
            <ul class="nav-dropdown y-dropdown-menu" style="display: none;">
                <li><span id="qrcode-btn">QR-код</span></li>
                <li><a href="/createPost/?id=<?= $this->article['src']; ?>">Редактировать</a></li>
                <li><a href="index.php?complain=1&amp;id=2">Пожаловаться</a></li>
            </ul>
        </div>
    </div>
</div>