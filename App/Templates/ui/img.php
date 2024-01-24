<?
$this->setCss('ui-img');

$tmp = [
    'name' => getUi($ui, 'name'),
    'src' => getUi($ui, 'src'),
    'classes' =>  getUi($ui, 'classes'),
    "descr" => false
];
?>

<figure class="ui-image <?= $tmp['classes'] ?>">
    <img src=" <?= $tmp['src'] ?>" alt=" <?= $tmp['name'] ?>">
    <? if ($tmp['descr']) : ?>
        <figcaption>
            <?= $tmp['name'] ?>
        </figcaption>
    <? endif ?>
</figure>