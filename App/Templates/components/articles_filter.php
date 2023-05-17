<!-- <div class="input__wrapper">
  <input id="popup-article-info-title" class="input" type="text" placeholder="Поиск по названию статьи" value="<?= $this->article['title']; ?>" />
</div>
<div class="input__row">

  <div class="input__wrapper mw">
    <label class="label">Категория</label>
    <select id="popup-article-info-category" class="select" type="text" placeholder="placeholder">

      <? foreach ($this->categories as $item) : ?>
        <? var_dump($item); ?>
        <option value="<?= $item['id']; ?>" <?= ($category == 1) ? 'selected' : ''; ?>>
          <?= $item['name']; ?>
        </option>
      <? endforeach ?>
    </select>
  </div>

  <div class="input__wrapper mw">
    <label class="label">Автор</label>
    <select id="popup-article-info-category" class="select" type="text" placeholder="Placeholder">
      <option value="1" <?= ($category == 1) ? 'selected' : ''; ?>>Код</option>
    </select>
  </div>

  <div class="input__wrapper mw">
    <label class="label">Теги</label>
    <div class="type-container">
      <input type="checkbox" id="job1" class="job-style" checked="">
      <label for="job1">Full Time Jobs</label>
      <span class="job-number">56</span>
    </div>
    <div class="type-container">
      <input type="checkbox" id="job1" class="job-style" checked="">
      <label for="job1">Full Time Jobs</label>
      <span class="job-number">56</span>
    </div>
    </select>
  </div>


</div> -->