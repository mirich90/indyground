<?
$this->setCss('row');
$this->setCss('btn');

$tmp = [
    'text' => getUi($ui, 'text'),
    'id' => (isset($ui['id'])) ? "id = {$ui['id']}" : "",
    'classes' =>  getUi($ui, 'classes'),
    'data-id' => (isset($ui['data-id'])) ? "data-id = {$ui['data-id']}" : '',
    'data-src' => (isset($ui['data-src'])) ? "'data-src = {$ui['data-src']}" : '',
    'src' => (isset($ui['src'])) ? "href = {$ui['src']}" : '',
];
?>

<? if ($tmp['src'] === '') : ?>

    <div class="wrapper-btn">
        <button <?= $tmp['id']; ?> class="btn <?= $tmp['classes']; ?>" <?= $tmp['data-id']; ?>>
            <?= $tmp['text'] ?>
        </button>
    </div>

<? else : ?>

    <div class="wrapper-btn">
        <a <?= $tmp['id']; ?> class="btn <?= $tmp['classes']; ?>" <?= $tmp['data-id']; ?> <?= $tmp['src']; ?>>
            <?= $tmp['text'] ?>
        </a>
    </div>

<? endif ?>