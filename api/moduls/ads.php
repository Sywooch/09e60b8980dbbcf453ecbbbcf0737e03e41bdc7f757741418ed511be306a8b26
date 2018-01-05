<?php

class Ads {

    public static $new = 0;
    public static $update = 1;
    public static $hide = 2;
    public static $allw = 10;

    public function getList() {
        $data = null;
        $cat_id = null;
        if (!empty($_GET['cat_id'])) {
            if ((int) $_GET['cat_id'] > 0) {
                $cat_id = (int) $_GET['cat_id'];
            }
        }
        $data['reklama'] = self::reklama($cat_id);
//        $data['category_list'] = self::categoryList($cat_id);
        $data['category_list'] = CATEGORY::get('ads', $cat_id);
        if (!empty($data['category_list'])) {
            $data['item_list'] = [];
        } else {
            $data['item_list'] = self::itemList($cat_id);
        }
        $user_ids = array_unique(self::getUsersId($data['item_list']));
        if (!empty($user_ids)) {
            $data['users'] = User::getUsers($user_ids);
        } else {
            $data['users'] = [];
        }

        return $data;
    }

    private static function itemList($cat_id = null) {
        $data = [];
        $query = null;
        if ($cat_id) {
            $query = "SELECT * FROM ads "
                    . " WHERE (category_id  LIKE ('%," . $cat_id . "') OR category_id = '$cat_id') "
                    . " AND published = 1 AND `status` != " . self::$hide . " ORDER BY id DESC ";
        }
        // var_dump($query);die;
        if ($query) {
            $data = DB::q_array($query);
            foreach ($data as $id => $vol) {
                $data[$id]['created_at'] = DATA::communication($vol['created_at']);
                $data[$id]['updated_at'] = DATA::communication($vol['updated_at']);
            }
        }

        return $data;
    }

    public function hide() {
        $data = null;
        $user = User::get();
        if (!empty($_GET['id'])) {
            $id = (int) $_GET['id'];
            if ($id > 0) {
                $query = "UPDATE ads  SET `status` = " . self::$hide . " WHERE id =" . $id . " AND user_id = " . $user['id'];
                $c = DB::q_($query);
//                var_dump($query);die;
                if ($c) {
                    $data['error'] = ['code' => 1, 'message' => 'INTERNAL ERROR'];
                } else {
                    $data = 'OK';
                }
            }
        }
        return $data;
    }

    private static function reklama() {
        $data = new stdClass();
        $query = "SELECT * FROM advertising_banner ";
        $vol = DB::q_line($query);
        if ($vol) {
            $tel = '';
            $type = '';
            $model = '';
            $url = '';
            if ($vol['organization_id'] > 0) {
                $id = $vol['organization_id'];
                $url = '/Organizations.get?id=' . $id;
                $model = 'Organizations';
                $type = 'item';
            } elseif ($vol['category_id'] > 0) {
                $id = $vol['category_id'];
                $url = '/Organizations.getList?cat_id=' . $id;
                $model = 'Organizations';
                $type = 'cat';
            } else {
                $id = '';
                if (filter_var($vol['url'], FILTER_VALIDATE_URL)) {
                    $url = $vol['url'];
                    $model = 'Url';
                    $type = 'url';
                } elseif (!empty($vol['telephone'])) {
                    $tel = $vol['telephone'];
                    $model = 'Tel';
                    $type = 'tel';
                }
            }
            $data->id = $id;
            $data->title = '';
            $data->url = $url;
            $data->model = $model;
            $data->image = $vol['image'];
            $data->telephone = $tel;
            $data->type = $type;
        }
        return $data;
    }

    public function get() {
        $data = null;
        if (!empty($_GET['id'])) {
            $id = (int) $_GET['id'];
            if ($id > 0) {
                $query = "SELECT * FROM ads WHERE id =" . $id;
                $c = DB::q_line($query);
                if ($c) {
                    $c['created_at'] = DATA::communication($c['created_at']);
                    $c['updated_at'] = DATA::communication($c['updated_at']);

                    $c['comments'] = COMMENTS::execute('ads_id', $c['id']);
                }
                $data['item'] = $c;
                $user_ids = array_unique(self::getUsersId($c));
                $data['users'] = User::getUsers($user_ids);
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

                if (!empty($_GET['id'])) {
                    if (!empty($comm)) {
                        $query = " UPDATE ads SET "
                                . " text = '" . DB::res($comm) . "' WHERE  user_id =  $user_id  AND  id = " . (int) $_GET['id'];
//                        var_dump($query);die;
                    }
                } elseif (!empty($_GET['cat_id'])) {
                    if ((int) $_GET['cat_id'] > 0) {
                        $cat = (int) $_GET['cat_id'];
                        $img = IMAGE::PostImgSave();
                        if (!empty($comm) || $img) {
                            $query = " INSERT INTO ads "
                                    . " SET img = '" . $img . "', "
                                    . " text = '" . DB::res($comm)
                                    . "', user_id =  $user_id, "
                                    . " category_id = $cat, "
                                    . " created_at = NOW() ";
                        }
                    }
                }
            }
        }
//        var_dump($query);die;
        $error = (!empty($query)) ? DB::q_($query) : 'empty';
        if (!$error) {
            return 'OK';
        }
    }

    public static function items($limit, $status) {
        $data = [];
        $query = null;
        $query = "SELECT * FROM ads "
                . " WHERE `status` != $status ORDER BY id DESC LIMIT $limit";

//        var_dump($query);die;
        $data['item_list'] = DB::q_array($query);
        foreach ($data['item_list'] as $id => $vol) {
            $data[$id]['created_at'] = DATA::communication($vol['created_at']);
            $data[$id]['updated_at'] = DATA::communication($vol['updated_at']);
        }
        $user_ids = array_unique(self::getUsersId($data['item_list']));
        if (!empty($user_ids)) {
            $data['users'] = User::getUsers($user_ids);
        } else {
            $data['users'] = [];
        }
        return $data;
    }

    public static function delete($id) {
        DB::q_("DELETE FROM ads WHERE id=" . $id);
    }

    public static function Approve($id) {
        DB::q_("UPDATE ads SET `status` = " . self::$allw . "  WHERE id = " . $id);
    }

}
