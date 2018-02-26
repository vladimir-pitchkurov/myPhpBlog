<?php

class ctrlIndex extends ctrl
{

    function index()
    {
        $this->comments = $this->db->query("SELECT * FROM comments ORDER BY TIME ")->all();
        $this->posts = $this->db->query("SELECT * FROM blog ORDER BY DATE DESC ")->all();
        $this->out('posts.php');

    }

    function login()
    {
        if (!empty($_COOKIE['coo'])) {
            if ($user = $this->db->query("SELECT user_name, email, user_id FROM users WHERE cookies = ? ", $_COOKIE['coo'])->assoc()) {
                header("Location: /");
            };

        }
        if (!empty($_COOKIE['userGoogleInfo_id']) && ($_COOKIE['data'] == 'no')) {
            $str1 = $this->db->query("SELECT profile FROM users WHERE email = ? ", $_COOKIE['email'])->assoc();
            if ($str1['profile'] != $_COOKIE['userGoogleInfo_id']) {
                $this->db->query("INSERT INTO users ( user_name, email, profile, cookies, picture) VALUES ( ?, ?, ?, ?, ?)", htmlspecialchars($_COOKIE['name']), htmlspecialchars($_COOKIE['email']), htmlspecialchars($_COOKIE['userGoogleInfo_id']), htmlspecialchars(md5($_COOKIE['userGoogleInfo_id'])), htmlspecialchars($_COOKIE['picture']));
            }
            $coo = htmlspecialchars(md5($_COOKIE['userGoogleInfo_id']));
            setcookie('coo', $coo, time() + 86400 * 3);
            setcookie('email', '', 0);
            setcookie('data', '', 0);
            setcookie('name', '', 0);
            setcookie('link', '', 0);
            setcookie('picture', '', 0);
            setcookie('userGoogleInfo_id', '', 0);
            header("Location: /");
        }

        if ($user = $this->db->query("SELECT user_name, email, user_id FROM users WHERE cookies = ? ", $_COOKIE['coo'])->assoc()) {
            header("Location: /");
        } else $this->error = 'Неправильный емейл или пароль';
        $this->out('login.php');
    }

    function logout()
    {
        setcookie('coo', '', 0);
        $this->user = false;
        header("Location: /");
    }

    function add()
    {
        if (!$this->user) return header("Location: /?login");
        if (!empty($_POST)) {
            $this->db->query("INSERT INTO blog (title,text,user_id,author) VALUES(?,?,?,?)", htmlspecialchars($_POST['title']), $_POST['post'], $this->user['user_id'], $this->user['user_name']);
            header("Location: /");
        }
        $this->out('add.php');
    }

    function del($postId)
    {
        if (!$this->user) return header("Location: /?login");
        $post_user = $this->db->query('SELECT user_id FROM blog WHERE id = ?', $postId)->assoc()['user_id'];
        if ($this->user['user_id'] != $post_user) {
            return header("Location: /?login");
        } else {
            $this->db->query("DELETE FROM blog WHERE id = ?", $postId);
            $this->db->query("DELETE FROM comments WHERE post_id = ?", $postId);
            header("Location: /?login");

        }
    }

    function post($id)
    {
        $this->post = $this->db->query("SELECT * FROM blog WHERE id = ?", $id)->assoc();
        if ($this->user['user_id'] == $this->post['user_id']) {
            if (!empty($_POST)) {
                $this->db->query("UPDATE blog SET title = ?, text = ? WHERE id = ?", htmlspecialchars($_POST['title']), htmlspecialchars($_POST['post']), $id);
                header("Location: /");
            }
            $this->comments = $this->db->query("SELECT * FROM comments WHERE post_id = ? ORDER BY TIME", $id)->all();
            $this->out('post.php');

        } else {
            header("Location: /");
        }
    }

    function addComment($postid)
    {
        if (!$this->user) {
            header("Location: /?login");
        } else if (!empty($_POST)) {
            $this->db->query("INSERT INTO comments (post_id, user_id, embedded, author, text_comment) VALUES(?,?,?,?,?)", intval($postid), $this->user['user_id'], 0, htmlspecialchars($this->user['user_name']), htmlspecialchars($_POST['comment']));
            header("Location: /");
        } else {
            header("Location: /");
        }
    }

    function delComment($commid)
    {
        if (!$this->user) return header("Location: /?login");
        if ($this->user['user_id'] == $this->db->query('SELECT user_id FROM comments WHERE id = ?', $commid)->assoc()['user_id'])
            $this->db->query("DELETE FROM comments WHERE id = ?", $commid);
        header("Location: /");
    }

    function editComment($commentId)
    {
        if (!$this->user) return header("Location: /?login");
        $this->comment = $this->db->query('SELECT * FROM comments WHERE id = ?', $commentId)->assoc();
        if ($this->user['user_id'] == $this->db->query('SELECT user_id FROM comments WHERE id = ?', $commentId)->assoc()['user_id']) {
            if (!empty($_POST)) {
                $this->db->query("UPDATE comments SET text_comment = ? WHERE id = ?", htmlspecialchars($_POST['comment']), $commentId);
                header("Location: /");
            } else {
                $this->out('editComment.php');
            }
        }

    }

    function reply($commId)
    {
        if (!$this->user) return header("Location: /?login");
        if (!empty($_POST)) {
            $post_c_id = $this->db->query('SELECT post_id FROM comments WHERE id = ?', $commId)->assoc()['post_id'];
            $this->db->query("INSERT INTO comments (post_id, user_id, embedded, author, text_comment) VALUES(?,?,?,?,?)", intval($post_c_id), $this->user['user_id'], $commId, htmlspecialchars($this->user['user_name']), htmlspecialchars($_POST['to_reply']));
            header("Location: /");
        } else {
            $this->comm_id = $commId;
            $this->out('reply.php');

        }

    }

}

?>