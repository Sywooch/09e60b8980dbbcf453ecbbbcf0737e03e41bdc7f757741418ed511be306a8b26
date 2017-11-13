<?php

function renderText($data, $i = 0, $arr = null) {
//    var_dump($arr);
    if (is_array($data)) {
        foreach ($data as $key => $vol) {
            if (!is_array($vol)) {
                if ($key == 'text') {
//                        die();
                    // Strip HTML Tags
                    $clear = strip_tags($vol);
// Clean up things like &amp;
                    $clear = html_entity_decode($clear);
// Strip out any url-encoded stuff
                        $clear = urldecode($clear);
//// Replace non-AlNum characters with space
//                    $clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
//// Replace Multiple spaces with single space
//                        $clear = preg_replace('/ +/', ' ', $clear);
// Trim the string of leading/trailing space
                    $clear = trim($clear);
//                        die($clear);
                    $data[$key] = filter_var($clear, FILTER_SANITIZE_STRING);
//                        $data[$key] = strip_tags($vol);
                    return $data;
//                    var_dump($data, $i++ . "### " . print_r($arr) . " ############\r\n<br>");die;
                }
            } else {
                $data[$key] = renderText($vol, $i, $arr);
            }
            $arr[] = $key;
        }
    }
    return $data;
}

class News {

    public function getList() {
        $cat_sel = 'n.category_id < 1';
        if (!empty($_GET['cat_id'])) {
            if ((int) $_GET['cat_id'] > 0) {
                $cat_sel = 'n.category_id = ' . (int) $_GET['cat_id'];
            }
        }
        $data['top'] = self::getList_top($cat_sel);
        $data['list'] = self::getList_secondary($cat_sel);
        return $data;
    }

    private static function getList_top($cat_sel) {
        $query = "SELECT n.id, n_d.title , "
                . " (SELECT n_i.image "
                . " FROM news_image n_i "
                . " WHERE n_i.news_id = n.id "
                . " ORDER BY sort_order DESC LIMIT 1) as image , "
                . " n.created_at as `date` "
                . " FROM news n "
                . " LEFT JOIN news_data n_d ON (n_d.nid = n.id) "
                . " WHERE n_d.title != '' AND  $cat_sel  AND n.type = 2 "
                . " ORDER BY `date` DESC ";
        return DB::q_array($query);
    }

    private static function getList_secondary($cat_sel) {
        $query = "SELECT n.id, n_d.title , "
                . " (SELECT n_i.image "
                . " FROM news_image n_i "
                . " WHERE n_i.news_id = n.id "
                . " ORDER BY sort_order DESC LIMIT 1) as image , "
                . " n.created_at as `date` "
                . " FROM news n "
                . " LEFT JOIN news_data n_d ON (n_d.nid = n.id) "
                . " WHERE n_d.title != '' AND  $cat_sel  AND n.type = 1 "
                . " ORDER BY `date` DESC ";
        return DB::q_array($query);
    }

    public function getCat() {
        return DB::q_array("SELECT id, title, image FROM news_category WHERE published = 1");
    }

    public function get() {
        $data = ['item' => [], 'users' => []];
        if (!empty($_GET['id'])) {
            if ((int) $_GET['id'] > 0) {

                $query = "SELECT id, "
                        . " created_at as `date`, "
                        . " video_url as video, "
                        . " source_url as url "
                        . " FROM news "
                        . " WHERE id = " . (int) $_GET['id'];
                $item = DB::q_line($query);
                if ($item) {
//                    self::comment($item['id']);
                    $comments = COMMENTS::execute('news_id', $item['id']);
                    $data['item'] = $item;
                    $query = "SELECT `title`, `text` FROM news_data WHERE nid = " . $item['id'];
                    $n_d = DB::q_array($query);
                    $data['item'] = array_merge((array) $data['item'], (array) $n_d);

                    $query = "SELECT image FROM news_image WHERE news_id = " . $item['id'];
                    $data['item']['image'] = DB::q_array($query);

                    if ($comments) {
                        foreach ($comments as $vol) {
                            $user_ids[] = $vol['user_id'];
                        }
                    }
                    $data['item']['comments'] = $comments;
                    if (!empty($user_ids)) {
                        $user_ids = array_unique($user_ids);
                        $data['users'] = User::get($user_ids);
                    }
                }
            }
        }
        return renderText($data);
//        return $data;
    }

    public static function comment($news_id = null, $organizations_id = null) {
        if (!empty($_POST['comment'])) {
            if (!empty($_GET['comment_id'])) {
                $comment_id = (int) $_GET['comment_id'];
                if ($comment_id > 0) {
                    self::commmentUpdate($comment_id);
                }
            } else {
                self::commmentInsert($news_id = null, $organizations_id = null);
            }
        }
    }

    public static function commmentUpdate($id) {
        $user = User::get();
        if ($user && $id) {
            $comm = trim($_POST['comment']);
            if (!empty($comm)) {
                $query = "UPDATE `comments` SET "
                        . " comment = '" . DB::res($comm) . "' , "
                        . " status = 2 WHERE id = " . $id . " "
                        . " AND user_id = " . $user['id'];
                DB::q_($query);
            }
        }
    }

    public static function commmentInsert($news_id = null, $organizations_id = null) {
        $user = User::get();
        if ($user) {
            $comm = trim($_POST['comment']);
            if (!empty($comm)) {
                $query = "INSERT INTO `comments` SET "
                        . " news_id = '$news_id' , "
                        . " organizations_id = '$organizations_id' ,"
                        . " user_id = " . $user['id'] . ", "
                        . " comment = '" . DB::res($comm) . "' , status = 1, "
                        . " created_at = NOW() ";
                $error = DB::q_($query);
            }
        }
    }

}
