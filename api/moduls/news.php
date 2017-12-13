<?php

function renderText($data, $i = 0, $arr = null) {
//    var_dump($arr);
    if (is_array($data)) {
        foreach ($data as $key => $vol) {
            if (!is_array($vol)) {
                if ($key == 'text') {
                    $clear = strip_tags($vol);
                    $clear = html_entity_decode($clear);
                    $clear = urldecode($clear);
                    $clear = trim($clear);
                    $data[$key] = filter_var($clear, FILTER_SANITIZE_STRING);
                    return $data;
                }
                if ($key == 'created_at') {
                    $data['date'] = DATA::comments($data)['created_at'];
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
        $data = DB::q_array($query);
        if (!empty($data)) {
            $data = DATA::news($data);
        }
        return $data;
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
        $data = DB::q_array($query);
        if (!empty($data)) {
            $data = DATA::news($data);
        }
        return $data;
    }

    public function getCat() {
//        var_dump(DB::q_array("SELECT id, title, image FROM news_category WHERE published = 1"));die;
        return DB::q_array("SELECT id, title, image FROM news_category WHERE published = 1");
    }

    public function get() {
        $data = ['item' => [], 'users' => []];
        if (!empty($_GET['id'])) {
            if ((int) $_GET['id'] > 0) {

                $query = "SELECT id, "
                        . " created_at , "
                        . " video_url as video, "
                        . " source_url as url "
                        . " FROM news "
                        . " WHERE id = " . (int) $_GET['id'];
                $item = DB::q_line($query);
                if ($item) {
//                    self::comment($item['id']);

                    $data['item'] = $item;
                    $query = "SELECT `title`, `text` FROM news_data WHERE nid = " . $item['id'];
                    $n_d = DB::q_array($query);
                    $data['item'] = array_merge((array) $data['item'], (array) $n_d);

                    $query = "SELECT image FROM news_image WHERE news_id = " . $item['id'];
                    $data['item']['image'] = DB::q_array($query);
                    $data = renderText($data);
                    $comments = COMMENTS::execute('news_id', $item['id']);
                    if ($comments) {
                        foreach ($comments as $vol) {
                            $user_ids[] = $vol['user_id'];
                        }
                    }
                    $data['item']['comments'] = $comments;
                    if (!empty($user_ids)) {
                        $user_ids = array_unique($user_ids);
                        $data['users'] = User::getUsers($user_ids);
                    }
                }
            }
        }
        return $data;
//        return $data;
    }

}
