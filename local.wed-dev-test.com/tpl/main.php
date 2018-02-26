<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0 max-width=1200px">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <title>My Blog</title>
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">Мой блог или форум</a>
            <div class="nav-collapse"><ul class="nav"><? if (!$this->user){ ?>
                        <li><a href="/?login">Войти</a></li>
                        <li><a href="/?login"><h4>Добро пожаловать, Гость! чтобы писать посты и оставлять комментарии, необходимо войти</h4></a></li>
                    <? } if ($this->user) { ?>
                        <li><a href="/?add">Добавить пост</a></li>
                        <li><a href="/?logout">Выйти</a></li>
                        <li><a><h4>Добро пожаловать, <? echo htmlspecialchars($this->user['user_name']); ?></h4></a>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="body-content" class="container">
    <div class="row">
        <?php $this->out($this->tpl, true); ?>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js">></script>
</body>
</html>