<!-- 
    $this->view->comments = array(
      'sum_comments' => $this->view->article['sum_comments'],
      'parent_id' => $this->view->article['id'],
      'table' => "article"
    );
 -->
<?
$this->setJs('loadComments');

$this->setCss('input');
$this->setCss('comments');
?>

<section id="comments" class="section container">
    <?php
    $button = '';
    $noComment = '';
    $styleCenter = '';
    if ($this->comments['sum_comments'] === '0') {
        $button = "hidden";
        $noComment = 'Комментариев пока нет';
        $styleCenter = 'text-align: center;';
    }
    ?>

    <button class="load-comments-btn button grey <?= $button; ?>" data-id="<?= $this->comments['parent_id']; ?>" data-sort="new" data-table="<?= $this->comments['table']; ?>">
        Загрузить комментарии (<?= $this->comments['sum_comments']; ?>)
    </button>

    <section class="load-comments">
        <section class="comments-header hidden">
            <p>Комментарии:</p>
            <ul>
                <li class="load-comments-btn load-comments-new active" data-id="<?= $this->comments['parent_id']; ?>" data-sort="new" data-table="<?= $this->comments['table']; ?>">
                    Новые
                </li>
                <li class="load-comments-btn load-comments-old" data-id="<?= $this->comments['parent_id']; ?>" data-sort="old" data-table="<?= $this->comments['table']; ?>">
                    Старые
                </li>
                <li class="load-comments-btn load-comments-best" data-id="<?= $this->comments['parent_id']; ?>" data-sort="best" data-table="<?= $this->comments['table']; ?>">
                    Лучшие
                </li>
            </ul>
        </section>
        <section class="comments" style="<?= $styleCenter ?>">
            <?= $noComment; ?>
        </section>
    </section>

</section>

<p style="text-align: center;">* * *</p>