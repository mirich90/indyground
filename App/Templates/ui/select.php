<?
$this->setCss('row');
$this->setCss('inp');

// options = [
//  ['value' => 'js',
//  'text' => 'javascript'],
// ]

$tmp = [
    'id' => getUi($ui, 'id'),
    // 'classes' => getUi($ui, 'classes'),
    'type' => getUi($ui, 'type'),
    'placeholder' => getUi($ui, 'placeholder'),
    'options' => getUi($ui, 'options'),
    'label' => getUi($ui, 'label'),
    'classes-label' => getUi($ui, 'label'),
];

?>

<div class="wrapper-input">

    <label class="label <?= $tmp['classes-label']; ?>" for="<?= $tmp['id']; ?>">
        <?= $tmp['label']; ?>
    </label>

    <select id="<?= $tmp['id']; ?>" type="<?= $tmp['type']; ?>" placeholder="<?= $tmp['placeholder']; ?>" tabindex="0">

        <? foreach ($tmp['options'] as $option) : ?>
            <option value="<?= $option['value']; ?>">
                <?= $option['text']; ?>
            </option>
        <? endforeach ?>
    </select>
</div>