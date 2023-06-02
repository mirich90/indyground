<?
$this->setCss('qr_code');
$this->setJs('qrcode.min');
$this->setJs('qrCode');
?>

<div id="qrcode-wrapper" class="modal-wrapper" data-qrcode="<?= $_SERVER['HTTP_REFERER']; ?>article/?id=<?= $this->article['src']; ?>">

    <div class="modal">
        <div class="modal-head">
            <p class="modal-title">Ссылки на статью</p>
            <a class="modal-btn-close modal-trigger"></a>
        </div>
        <div class="modal-content">
            <p>Перейти на страницу статьи с помощью этого qr-кода</p>
            <div id="qrcode">
                <img src="" alt="">
            </div>
        </div>
    </div>
</div>