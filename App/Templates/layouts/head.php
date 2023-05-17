<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title><?= $this->meta->title; ?></title>
    <meta name="description" content="<?= $this->meta->description; ?>">
    <meta name="keywords" content="<?= $this->meta->keywords; ?>">
    <meta name="author" content="<?= $this->meta->author; ?>">
    <? if ($this->meta->image !== "") : ?>
        <meta property="og:image" content="<?= $this->meta->image; ?>">
    <? endif ?>

    <link rel="shortcut icon" href="/img/static/favicon.png" type="image/png">
    <?= $this->displayCss($this->meta->name_page); ?>

    <script src="/minjs/handlers.js" defer></script>

    <script src="/minjs/lazyLoads.js" defer></script>
    <script src="/minjs/progressBar.js" defer></script>
    <!-- <script src="/minjs/preloader.js" defer></script> -->

    <?= $this->displayFonts(); ?>
    <?= $this->displayJs(); ?>

</head>