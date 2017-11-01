<?php

class Ads {

    public function getList() {
        $data = null;
        $cat_id = null;
        if (!empty($_GET['cat_id'])) {
            if ((int) $_GET['cat_id'] > 0) {
                $cat_id = (int) $_GET['cat_id'];
            }
        }
        $data['reklama'] = self::reklama($cat_id);
        $data['category_list'] = self::categoryList($cat_id);
        $data['item_list'] = self::itemList($cat_id);
        return $data;
    }

    private static function categoryList($cat_id = null) {
        $data = [];
        $query = null;
        if ($cat_id) {
            $cat = DB::q_line("SELECT * FROM ads_category WHERE id = " . $cat_id);
            if ($cat) {
                $query = "SELECT * FROM ads_category WHERE root = $cat[id] AND lvl = " . ($cat['lvl'] + 1) . " ";
            }
        } else {
            $query = "SELECT * FROM ads_category WHERE lvl = 0";
        }
        if ($query) {
            $data = DB::q_array($query);
        }
        return $data;
    }

    private static function itemList($cat_id = null) {
        $data = [];
        $query = null;
        if ($cat_id) {
            $query = "SELECT * FROM ads "
                    . " WHERE (category_id  LIKE ('%," . $cat_id . "') OR category_id = '$cat_id') "
                    . " AND published = 1 AND ";
        }
//        var_dump($query);die;
        if ($query) {
            $data = DB::q_array($query);
        }
        return $data;
    }

    private static function reklama() {
        return ['name' => 'Rek',
            'img' => '/uploads/images/ram/2016-06-24_21-35-50.png',
            'url' => 'https://dunpal.com',
            'tel' => '+799999999'
        ];
    }

    public function get() {
        $data = null;
        if (!empty($_GET['id'])) {
            $id = (int) $_GET['id'];
            if ($id > 0) {
                $query = "SELECT * FROM ads WHERE id =" . $id;
                $c = DB::q_line($query);
                if ($c) {
                    $c['comments'] = COMMENTS::execute('ads_id', $c['id']);
                }
                $data['item'] = $c;
                $user_ids = array_unique(self::getUsersId($c));
                $data['users'] = User::get($user_ids);
            }
        }
        return $data;
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

    public function post() {
        $query = null;
        $user = User::get();
        if ($user) {
            $user_id = (int) $user['id'];
            @$comm = trim($_POST['post']);
            if ($user_id > 0) {
                if (!empty($comm)) {
                    if (!empty($_GET['id'])) {
                        $query = " UPDATE ads SET "
                                . " text = '" . DB::res($comm) . "' WHERE  user_id =  $user_id  AND  id = " . (int) $_GET['id'];
//                        var_dump($query);die;
                    } elseif (!empty($_GET['cat_id'])) {
                        if ((int) $_GET['cat_id'] > 0) {
                            $cat = (int) $_GET['cat_id'];
                            $query = " INSERT INTO ads "
                                    . " SET  text = '" . DB::res($comm)
                                    . "', user_id =  $user_id, "
                                    . " category_id = $cat, "
                                    . " created_at = NOW() ";
                        }
                    }
                }
            }
        }
//        var_dump($query);die;
        $error = DB::q_($query);
        if (!$error) {
            return 'OK';
        }
    }

}
