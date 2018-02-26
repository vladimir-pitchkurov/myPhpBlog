<?php

class db{

    /**
     в примере проперти от базы захардкожены в конструкторе,
     * это не лучшее решение, но все собрано в одном месте и для примера, думаю не принципиально
     */
    public function __construct(){
        $this->mysqli = new mysqli('localhost', 'adm', 'adm', 'mytestdb');
    }

    /*безопасность и удобство в этом методе нашли кое-каkое отражение*/
    public function query($sql) {
        // $db->query("SELECT * FROM aslkd WHERE id = ?",$id);
        $args = func_get_args();
        $sql = array_shift($args);
        $link = $this->mysqli;
        $args = array_map(function ($param) use ($link) {
            return "'".$link->escape_string($param)."'";
        },$args);
        $sql = str_replace(array('%','?'), array('%%','%s'), $sql);
        array_unshift($args, $sql);
        $sql = call_user_func_array('sprintf', $args);
        $this->last = mysqli_query($this->mysqli, $sql);
        if ($this->last === false) throw new Exception('Database error: '.$this->mysqli->error);
        return $this;
    }

    /* удобно */
    public function assoc() {
        return $this->last->fetch_assoc();
    }

    /* удобно */
    public function all() {
        $result = array();
        while ($row = $this->last->fetch_assoc()) $result[] = $row;
        return $result;
    }

}