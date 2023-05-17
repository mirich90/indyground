<?
$this->setCss('ui-diagram');

$tmp = [
    'text' => getUi($ui, 'text'),
    'value' => (isset($ui['value'])) ? $ui['value'] : "0",
    'classes' =>  getUi($ui, 'classes'),
];
?>

<div class="ui-diagram <?= $tmp['classes'] ?>">
    <?= $tmp['value'] ?>
    <span></span>
</div>