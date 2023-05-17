<?
$this->setCss('picture');
$tmp = [
    'text' => ($cmp['text']) ? $cmp['text'] : "",
    'src' => $cmp['src'] ? $cmp['src'] : "",
    'classes' => (isset($cmp['classes'])) ? $cmp['classes'] : ""
];
?>

<picture class="component-picture <?= $tmp['classes']; ?>">
    <img src="<?= $tmp['src']; ?>" data-src="<?= $tmp['src']; ?>" alt="<?= $tmp['text']; ?>">
</picture>