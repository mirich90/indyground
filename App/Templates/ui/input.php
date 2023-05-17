<?
$this->setCss('row');
$this->setCss('inp');

$tmp = [
    'id' => getUi($ui, 'id'),
    'label' => getUi($ui, 'label'),
    'classes' => getUi($ui, 'classes'),
    'type' => getUi($ui, 'type'),
    'placeholder' => getUi($ui, 'placeholder'),
    'value' => getUi($ui, 'value'),
];
?>

<div class="wrapper-input">
    <label class="label" for="<?= $tmp['id']; ?>">
        <?= $tmp['label']; ?>
    </label>
    <input type="text" name="<?= $tmp['id']; ?>" id="<?= $tmp['id']; ?>" placeholder="<?= $tmp['placeholder']; ?>" autofocus="" autocomplete="off" value="<?= $tmp['value']; ?>" class="input <?= $tmp['classes']; ?>">
</div>