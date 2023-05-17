<?
$class = ($this->menu_1 === $cmp["name"]) ? 'active' : '';

$tmp = [
    'url' => ($cmp['url']) ? $cmp['url'] : "",
    'text' => ($cmp['text']) ? $cmp['text'] : "",
    'num' => $cmp['num'] ? $cmp['num'] : "",
    'count' => $cmp['count'] ? $cmp['count'] : ""
];
?>
      <a href="<?=$tmp['url'];?>" class="insight <?= $class; ?>">
        <div class="heading">
          <?=$tmp['text'];?>
          <div class="score">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 262.361 262.362" width="8" height="8" fill="#44c790">
              <path d="M286.935 197.287L159.028 69.381c-3.613-3.617-7.895-5.424-12.847-5.424s-9.233 1.807-12.85 5.424L5.424 197.287C1.807 200.904 0 205.186 0 210.134s1.807 9.233 5.424 12.847c3.621 3.617 7.902 5.425 12.85 5.425h255.813c4.949 0 9.233-1.808 12.848-5.425 3.613-3.613 5.427-7.898 5.427-12.847s-1.814-9.23-5.427-12.847z" />
            </svg>
            <span><?=$tmp['num'];?> %</span>
          </div>
        </div>
        <div class="number">
          <?=$tmp['count'];?>
          <div class="info">
            Подробнее
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </div>
        </div>
      </a>