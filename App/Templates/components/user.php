<?
$this->setCss('user');

$tmp = [
    'url' => ($cmp['url']) ? $cmp['url'] : "",
    'text' => ($cmp['text']) ? $cmp['text'] : "",
    'img-src' => $cmp['img-src'] ? $cmp['img-src'] : "",
    'classes' => (isset($cmp['classes'])) ? $cmp['classes'] : "",
    "bg" => (isset($cmp['bg'])) ? $cmp['bg'] : "none"
];
?>

<a href="<?= $tmp['url']; ?>" class="component-user <?= $tmp['classes']; ?> <?= $tmp['bg']; ?>">
    <?= $this->Component('picture', [
        'text' => $tmp['text'],
        'src' => $tmp['img-src'],
        'classes' => ""
    ]); ?>
    <p><?= $tmp['text']; ?></p>
</a>