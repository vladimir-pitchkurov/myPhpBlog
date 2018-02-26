<?php
include 'lib/googleCrd.php';
$this->user = $this->db->query("SELECT * FROM users WHERE cookies = ? ", $_COOKIE['key'])->assoc();
if ($this->user) {
    $this->out('posts.php');
} else {
    $google1 = new googleCrd();
    echo $link = '<div class=""><p align="center"><a id="button-google" href="' . 'https://accounts.google.com/o/oauth2/auth' . '?' . urldecode(http_build_query($google1->getParams())) . '" class="btn btn btn-large btn-success btn-lg btn-block "><i class="fa fa-google-plus visible-xs"></i><span class="hidden-xs">Google+</span></a></p></div>';
    $google1 = null;
}
?>
