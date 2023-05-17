<?
$this->setCss('tags');
$tmp = [
    'tags' => isset($cmp['tags']) ? $cmp['tags'] : [],
    'classes' => (isset($cmp['classes'])) ? $cmp['classes'] : "",
    'type' => (isset($cmp['type'])) ? $cmp['type'] : ""
];
?>

<ul class="component-tags  <?= $tmp['classes']; ?> <?= $tmp['type']; ?>" aria-label="Tags">
    <? foreach ($tmp['tags'] as $tag) : ?>
        <li>
            <a href="/index/?tag=<?= $tag ?>" aria-label="<?= $tag ?>">
                <? if ($tmp['type'] !== "tags-flat" && $tmp['type'] !== "tags-grey") echo "#" ?>
                <?= $tag ?>
            </a>
        </li>
    <? endforeach ?>
</ul>