<?php

/**
 * Created by IntelliJ IDEA.
 * User: Админ
 * Date: 23.02.2018
 * Time: 21:10
 */
class ctrl
{

    /**
     * ctrl constructor.
     */
    public function __construct()
    {
        $this->db = new db();
        $this->user = false;
        if (!empty($_COOKIE['coo']))
            $this->user = $this->db->query("SELECT user_name, email, user_id FROM users WHERE cookies = ? ", $_COOKIE['coo'])->assoc();

    }

    public function out($tplname, $nested = false)
    {
        if (!$nested) {
            $this->tpl = $tplname;
            include 'tpl/main.php';
        } else
            include 'tpl/' . $tplname;
    }
}

class app
{

    /**
     * app constructor.
     */
    public function __construct($path)
    {

        $this->route = explode('/', $path);
        $this->run();
    }

    /* функция в зависимости от содержимого строки браузера,
    подключает модули или обращается к методам */
    private function run()
    {
        $url = array_shift($this->route);

        /*это костыль для гугла, не лучшее решение*/
        if (substr($url, 0, 4) == 'code') {
            include 'googleCrd.php';
            $result = false;
            $google = new googleCrd();
            $google->setCode($_GET['code']);
            $userGoogleInfo = $google->getUserInfo();
            setcookie('userGoogleInfo_id', $userGoogleInfo['id'], time() + 86400 * 3);
            setcookie('email', $userGoogleInfo['email'], time() + 86400 * 3);
            setcookie('name', $userGoogleInfo['name'], time() + 86400 * 3);
            setcookie('link', $userGoogleInfo['link'], time() + 86400 * 3);
            setcookie('picture', $userGoogleInfo['picture'], time() + 86400 * 3);
            setcookie('data', 'no', time() + 86400 * 3);
            if (!empty($userGoogleInfo['id'])) {
                header('location:/?login');
            } else {
                echo "error authorization";
            }
            /* конец костыля */

        } else {
            if (!preg_match('#^[a-zA-Z0-9.,-]*$#', $url))
                throw new Exception('Invalid path');
            $ctrlName = 'ctrl' . ucfirst($url);
            if (file_exists('app/' . $ctrlName . '.php')) {
                $this->runController($ctrlName);
            } else {
                array_unshift($this->route, $url);
                $this->runController('ctrlIndex');
            }
        }
    }

    /* продолжение предидущей функции, в этом примере
    подключение контроллеров */
    private function runController($ctrlName)
    {
        include "app/" . $ctrlName . ".php";
        $ctrl = new $ctrlName();
        if (empty($this->route) || empty($this->route[0])) {
            $ctrl->index();
        } else {
            if (empty($this->route))
                $method = 'index';
            else
                $method = array_shift($this->route);
            if (method_exists($ctrl, $method)) {
                if (empty($this->route))
                    $ctrl->$method();
                else
                    call_user_func_array(array($ctrl, $method), $this->route);
            } else
                throw new Exception('Error 404');
        }
    }
}

?>