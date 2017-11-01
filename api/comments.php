<?

class COMMENTS {

    public static $new = 1;
    public static $update = 2;

    public static function execute($fild_name = null, $id = null) {
        if (!empty($_POST['comment'])) {
            if (!empty($_GET['comment_id'])) {
                $comment_id = (int) $_GET['comment_id'];
                if ($comment_id > 0) {
                    self::commmentUpdate($comment_id);
                }
            } else {
                self::commmentInsert($fild_name, $id);
            }
        }
        return self::item_comments($fild_name, $id);
    }

    public static function commmentUpdate($id) {
        $user = User::get();
        if ($user && $id) {
            $comm = trim($_POST['comment']);
            if (!empty($comm)) {
                $query = "UPDATE `comments` SET "
                        . " comment = '" . DB::res($comm) . "' , "
                        . " status = " . self::$update . " WHERE id = " . $id . " "
                        . " AND user_id = " . $user['id'];
                DB::q_($query);
            }
        }
    }

    public static function commmentInsert($fild_name = null, $id = null) {
        $user = User::get();
        if ($user) {
//            $img = IMAGE::CommentImgSave();
            $comm = trim($_POST['comment']);
            if (!empty($comm)) {
                $query = "INSERT INTO `comments` SET "
                        . " $fild_name = '$id' , "
                        . " user_id = " . $user['id'] . ", "
//                        . " img = '" . $img . "', "
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
                . " created_at, "
                . " updated_at "
                . " FROM `comments` "
                . " WHERE $fild_name = " . $id . " "
                . " ORDER BY id DESC";
        return DB::q_array($query);
    }

}
