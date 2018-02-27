<? if($this->user):?>
    <a href="/?add" class="btn btn-danger">Добавить пост</a>
    <? else:?>
    <a href="/?login" class="btn btn-danger" >Для добавления и комментирования сообщений, выполните вход</a>
    <? endif;?>
<? foreach ($this->posts as $key => $value): ?>
    <h3><a href="/?post/<?= $value['id'] ?>"><?= $value['title'] ?></a></h3>
    <p>Автор: <?= $value['author'] ?></p><p>(<?= $value['date'] ?>) <?= nl2br($value['text']) ?></p>
    <?php if ($this->user['user_id'] == $value['user_id']) { ?>
        <div class="btn-group" role="group" aria-label="Basic">
            <a href="/?post/<?= $value['id'] ?>" class="btn btn-mini btn-info">редактировать пост</a>
            <a href="/?del/<?= $value['id'] ?>" class="btn btn-mini btn-danger"
               onclick="return confirm('Точно удалить?');">удалить пост и все комменты</a>
        </div>
    <?php } ?>
    <div class="">
        <p>
            <? $counter = 0;
            foreach ($this->comments as $a): ?>
                <? if ($a['post_id'] == $value['id']):$counter += 1; endif; ?>
            <? endforeach; ?>
            <? if ($counter > 0): ?>
                <button class="btn btn-mini btn-info hide-comments" href="javascript:void(0)"
                        onclick='ShowHideContent(document.getElementById("post<?= $value['id'] ?>"))'>Читать / Свернуть
                    Комментарии(<?= $counter ?>)
                </button>
            <? endif; ?>
        </p>
        <div id="post<?= $value['id'] ?>" style="display: none;">

            <ul>
                <?php foreach ($this->comments as $c) {
                    ?>
                    <?php if ($c['post_id'] == $value['id'] && $c['embedded'] == 0) { ?>
                        <li><p>(<?= $c['time'] ?>) <?= $c['text_comment'] ?>  [автор: <?= $c['author'] ?>]
                                <? if ($this->user['user_id'] == $c['user_id']) : ?>

                                            <a href="/?editComment/<?= $c['id'] ?>" class="btn btn-mini btn-info">редактировать</a>
                                            <a href="/?reply/<?= $c['id'] ?>" class="btn btn-mini btn-primary">ответить</a>
                                            <a href="/?delComment/<?= $c['id'] ?>" class="btn btn-mini btn-danger"
                                               onclick="return confirm('Точно удалить?');">удалить</a>

                                <? endif ?>
                                <? if ($this->user): ?>
                                    <a href="/?reply/<?= $c['id'] ?>" class="btn btn-mini btn-primary">ответить</a>

                                <? else: ?>
                                    <a href="/?login">Для добавления и комментирования сообщений, выполните вход</a>
                                <? endif ?>
                            </p>
                            <ul>
                                <? foreach ($this->comments as $c_key => $c_value): ?>
                                    <? if ($c_value['embedded'] == $c['id']): ?>
                                        <li><p>(<?= $c_value['time']; ?>) <?= $c_value['text_comment'] ?> [ответил(а): <?= $c_value['author'] ?>]
                                                <? if ($c_value['user_id'] == $this->user['user_id']): ?>
                                                    <a href="/?editComment/<?= $c_value['id'] ?>" class="btn btn-mini btn-info">редактировать</a>
                                                    <a href="/?delComment/<?= $c_value['id'] ?>"
                                                       class="btn btn-mini btn-danger"
                                                       onclick="return confirm('Точно удалить?');">удалить</a>
                                                <? endif ?>
                                            </p>
                                        </li>
                                    <? endif ?>
                                <? endforeach; ?>
                            </ul>
                        </li>
                    <? }
                } ?>
            </ul>
        </div>
    </div>
    <? if ($this->user): ?>
        <form action="/?addComment/<?= $value['id']; ?>" method="post" class="form-inline well">
            <label>Ваш комментарий: </label> <input type="text" name="comment" style="height:12px;">
            <button type="submit" class="btn btn-mini btn-primary">Добавить</button>
        </form>
    <? else: ?>
        <a class="btn btn-info" href="/?login">Для добавления и комментирования сообщений, выполните вход </a>
    <? endif; ?>
    <br>
<? endforeach ?>