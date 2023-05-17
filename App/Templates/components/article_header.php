<?
$this->setCss('article_header');
?>

<div class="container-u article">
    <?php $image = getImagePreview($this->article['image'], $this->article['image_type']); ?>
    <picture class="article-item article-picture">
        <source type="image/webp" srcset="/img/static/post_template.wepb" data-src="<?= $image[1]; ?>">
        <img src="/img/static/post_template.png" data-src="<?= $image[0]; ?>" alt="<?= $this->article['image'] ?>">
    </picture>

    <div class="article-item article-info">

        <ul class="breadcrumbs">
            <li><a href="asd" class="details">Статьи / </a></li>
            <li><a href="/index/?category=<?= $this->article['category'] ?>" class="details"><?= $this->article['category_name'] ?></a></li>
        </ul>

        <h1 id="title">
            <?= $this->article['title'] ?>
        </h1>

        <?php $image = ($this->article["ava"]) ? "avatars/" . $this->article["ava"] : 'static/ava.png'; ?>
        <a href="/profile/?username=<?= $this->article['username'] ?>" class="article-author">
            <picture>
                <img src="/img/static/post_template.png" data-src="/img/<?= $image; ?>" alt="<?= $this->article['name'] ?>">
            </picture>
            <?= $this->article['name'] ?>
        </a>

        <div class="article-info-meta">

            <time datetime="<?= $this->article['datetime'] ?>" class="article-date">
                <?= $this->article['datetime'] ?>
            </time>

            <ul class="article-tags" aria-label="Tags">
                <? foreach (array_filter(explode(",", $this->article['tags'])) as $tag) : ?>
                    <li>
                        <a href="/index/?tag=<?= $tag ?>" class="article-tag" aria-label="<?= $tag ?>">#<?= $tag ?></a>
                    </li>
                <? endforeach ?>
            </ul>
        </div>
    </div>
</div>