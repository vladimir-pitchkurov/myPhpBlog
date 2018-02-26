<form class="form-horizontal" method="post">

    <label>Заголовок</label>
    <input type="text" class="input-xxlarge" name="title" value="<?=@$this->post['title']?>" />
    <label>Текст</label>
    <textarea cols="50" class="input-xxlarge" name="post" style="height: 300px;"><?=@$this->post['text']?></textarea>

    <div class="form-actions"><button class="btn btn-primary" type="submit">Готово!</button></div>

</form>