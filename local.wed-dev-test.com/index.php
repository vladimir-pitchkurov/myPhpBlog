<?php
/**
 * Created by IntelliJ IDEA.
 * User: Админ
 * Date: 23.02.2018
 * Time: 20:08
 */
include 'lib/db.php';
include 'lib/base.php';
new app(substr($_SERVER['REQUEST_URI'], 2));