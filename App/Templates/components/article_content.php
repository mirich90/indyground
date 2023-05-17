<article>
    <? $is_ul = false; ?>
    <? foreach ($this->contents as $content) : ?>
      <?php
      if ($content['tag'] == 'li' && !$is_ul) {
        $is_ul = true;
        echo '<ul>';
      } elseif ($is_ul && $content['tag'] != 'li') {
        $is_ul = false;
        echo '</ul>';
      }
      ?>

      <? if ($content['tag'] == 'img') : ?>
        <figure>
          <img src="<?= $content['src'] ?>" alt="<?= $content['alt'] ?>">
          <figcaption><?= $content['alt'] ?></figcaption>
        </figure>
        
      <? elseif ($content['tag'] == 'table') : ?>
        <table>
          <caption><?=$content['alt'];?></caption>

          <tbody>
          <? foreach (json_decode($content['html'],true) as $key => $html ) : ?>
            <tr>
            <? foreach ($html as $td) : ?>
              <? if ($key === 0) : ?>
                <th><?=$td;?></th>
              <? else : ?>
                <td><?=$td;?></td>
              <? endif ?>

            <? endforeach ?>
            </tr>
          <? endforeach ?>

          </tbody>

        </table>

      <? else : ?>

        <<?= $content['tag'] ?>><?= $content['html'] ?></<?= $content['tag'] ?>>

      <? endif ?>
    <? endforeach ?>

    <hr>
    <p style="text-align: center;">* * *</p>
  </article>