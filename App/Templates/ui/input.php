<?
$this->setCss('row');
$this->setCss('inp');

$tmp = [
    'id' => getUi($ui, 'id'),
    'classes' => getUi($ui, 'classes'),
    'type' => getUi($ui, 'type'),
    'placeholder' => getUi($ui, 'placeholder'),
    'value' => getUi($ui, 'value'),
    'label' => getUi($ui, 'label'),
    'classes-label' => getUi($ui, 'label'),
];

if ($tmp['type'] === 'file') $tmp['classes-label'] = 'label-file';
?>

<div class="wrapper-input">
    <label class="label <?= $tmp['classes-label']; ?>" for="<?= $tmp['id']; ?>">
        <?= $tmp['label']; ?>
    </label>

    <input type="<?= $tmp['type']; ?>" name="<?= $tmp['id']; ?>" id="<?= $tmp['id']; ?>" placeholder="<?= $tmp['placeholder']; ?>" autofocus="" autocomplete="off" value="<?= $tmp['value']; ?>" class="input <?= $tmp['classes']; ?>">
</div>