<form action="/?editComment/<?=$this->comment['id'] ?>" method="post" class="form-inline well">
    <label>Ваш комментарий: </label> <input type="text" name="comment" value="<?=$this->comment['text_comment']?>">
    <button type="submit" class="btn btn-primary">Готово</button>
</form>