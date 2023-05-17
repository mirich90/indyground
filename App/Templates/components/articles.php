<div class="container-lg">

  <h1 id="title">Последние посты <?= $this->h1; ?></h1>

  <?= $this->Component('articles_filter'); ?>

  <div class="articles">

    <? if (count($this->articles) === 0) : ?>
      <article class="article">Пока статей нет</article>
    <? endif ?>

    <? foreach ($this->articles as $article) : ?>
      <article class="article">

        <?php $image = getImagePreview($article["image"], $article["image_type"]); ?>
        <a href="/article/?id=<?= $article["src"]; ?>" class="article-item article-picture" aria-label="Перейти на страницу '<?= $article["title"] ?>'">
          <picture>
            <source type="image/webp" srcset="/img/static/post_template.wepb" data-src="<?= $image[1]; ?>">
            <img src="/img/static/post_template.png" data-src="<?= $image[0]; ?>" alt="<?= $article["image"]; ?>">
          </picture>
        </a>

        <div class="article-item article-info">

          <div class="article-info-meta">

            <time datetime="<?= $article["datetime"]; ?>" class="article-date">
              <?= $article["datetime"]; ?>
            </time>

            <ul class="article-tags" aria-label="Tags">
              <? foreach (array_filter(explode(",", $article["tags"])) as $tag) : ?>
                <li>
                  <a href="/index/?tag=<?= $tag; ?>" class="article-tag" aria-label="<?= $tag; ?>">#<?= $tag; ?></a>
                </li>
              <? endforeach ?>

            </ul>

          </div>

          <h2>
            <a href="/article/?id=<?= $article["src"]; ?>"><?= $article["title"]; ?></a>
          </h2>


          <a href="/profile/?username=<?= $article["username"]; ?>" class="article-author">
            <picture>
              <img src="/img/static/post_template.png" data-src="/img/static/ava.png" alt="<?= $article["name"]; ?>">
            </picture>
            <?= $article["name"]; ?>
          </a>

          <p><?= $article["description"]; ?></p>
        </div>
      </article>
    <? endforeach ?>

  </div>

</div>