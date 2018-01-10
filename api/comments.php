<?

class COMMENTS {

    public static $new = 1;
    public static $update = 2;
    public static $hide = 3;
    public static $allw = 10;

    public static function execute($fild_name = null, $id = null) {
        $data = [];
        if (!empty($_POST['comment']) || isset($_FILES['comment_photo'])) {
            if (!empty($_GET['comment_id'])) {
                $comment_id = (int) $_GET['comment_id'];
                if ($comment_id > 0) {
                    self::commmentUpdate($comment_id);
                }
            } else {
                self::commmentInsert($fild_name, $id);
            }
        }
        if (!empty($_POST['hide_comment'])) {
            if (!empty($_GET['comment_id'])) {
                $comment_id = (int) $_GET['comment_id'];
                if ($comment_id > 0) {
                    self::commmentHide($comment_id);
                }
            }
        }
        $data = self::item_comments($fild_name, $id);

        return $data;
    }

    public static function commmentHide($id) {
        $user = User::get();
        if ($user && $id) {
            $query = "UPDATE `comments` SET "
                    . " status = " . self::$hide . " WHERE id = " . $id . " "
                    . " AND user_id = " . $user['id'];
            DB::q_($query);
        }
    }

    public static function commmentUpdate($id) {
        $user = User::get();
        if ($user && $id) {
            $comm = trim($_POST['comment']);
            $img = IMAGE::CommentImgSave();
            if (!empty($comm) || $img) {
                $s = '';
                $f = '';
                if (!empty($comm)) {
                    $s = " comment = '" . DB::res($comm) . "' , ";
                }
                if ($img) {
                    $f = " img = '" . $img . "', ";
                }
                $query = "UPDATE `comments` SET "
                        . $s
                        . $f
                        . " status = " . self::$update . " WHERE id = " . $id . " "
                        . " AND user_id = " . $user['id'];
                DB::q_($query);
            }
        }
    }

    public static function commmentInsert($fild_name = null, $id = null) {
        $user = User::get();
        if ($user) {
            $img = IMAGE::CommentImgSave();
            $comm = trim($_POST['comment']);
            if (!empty($comm) || $img) {
                $query = "INSERT INTO `comments` SET "
                        . " $fild_name = '$id' , "
                        . " user_id = " . $user['id'] . ", "
                        . " img = '" . $img . "', "
                        . " comment = '" . DB::res($comm) . "' , status = " . self::$new . ", "
                        . " created_at = NOW() ";
//                var_dump($query);die;
                $error = DB::q_($query);
            }
        }
    }

    public static function item_comments($fild_name = null, $id = null) {
        $query = "SELECT id, "
                . " `comment`, "
                . " user_id, "
                . " img, "
                . " created_at, "
                . " updated_at "
                . " FROM `comments` "
                . " WHERE $fild_name = " . $id . " "
                . " AND status != " . self::$hide
                . " ORDER BY id DESC";
        $data = DB::q_array($query);
        if (!empty($data)) {
            foreach ($data as $key => $vol) {
                $data[$key] = DATA::comments($data[$key]);
            }
        }

        return $data;
    }

    public static function delete($id) {
        $query = "DELETE FROM comments WHERE id = $id";
        DB::q_($query);
    }

    public static function items($limit, $status) {
        $data = null;
        $query = "SELECT * FROM comments WHERE `status` != $status ORDER BY id DESC LIMIT $limit";
        $c = DB::q_array_id($query);
        foreach ($c as $id => $vol) {
            $c[$id]['created_at'] = DATA::communication($vol['created_at']);
            $c[$id]['updated_at'] = DATA::communication($vol['updated_at']);
            $c[$id]['text'] = $vol['comment'];
        }
        $data['item_list'] = array_values($c);
        $user_ids = array_unique(self::getUsersId($c));
        $data['users'] = User::getUsers($user_ids);
        return $data;
    }

    public static function Approve($id) {
        DB::q_("UPDATE comments SET `status` = " . self::$allw . "  WHERE id = " . $id);
    }

    public static function getUsersId($array = []) {
        $data = [];
        if (!empty($array)) {
            foreach ($array as $key => $vol) {
                if (is_array($vol)) {
                    $data = array_merge($data, self::getUsersId($vol));
                } else {
                    if ($key == 'user_id') {
                        $data[] = (int) $vol;
                    }
                }
            }
        }
        return $data;
    }

}
