<?php

class Communication {

    public static $new = 0;
    public static $update = 1;
    public static $hide = 2;
    public static $allw = 10;

    public function getList() {
        $data = null;
        $query = "SELECT * FROM communication WHERE `status` != " . self::$hide . " ORDER BY id DESC";
        $c = DB::q_array_id($query);
        foreach ($c as $id => $vol) {
            $c[$id]['created_at'] = DATA::communication($vol['created_at']);
            $c[$id]['updated_at'] = DATA::communication($vol['updated_at']);
        }
        $data['list'] = array_values($c);
        $user_ids = array_unique(self::getUsersId($c));
        $data['users'] = User::getUsers($user_ids);
        return $data;
    }

    public function get() {
        $data = null;
        if (!empty($_GET['id'])) {
            $id = (int) $_GET['id'];
            if ($id > 0) {
                $query = "SELECT * FROM communication WHERE id =" . $id . " AND `status` != " . self::$hide;
                $c = DB::q_line($query);
                if ($c) {
                    $c['comments'] = COMMENTS::execute('communication_id', $c['id']);
                }
                $data['item'] = $c;
                $user_ids = array_unique(self::getUsersId($c));
                $data['users'] = User::getUsers($user_ids);
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
                $query = "UPDATE communication  SET `status` = " . self::$hide . " WHERE id =" . $id . " AND user_id = " . $user['id'];
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
//         var_dump(getallheaders());die;
        $query = null;
        $user = User::get();
        if ($user) {
            $user_id = (int) $user['id'];
            @$comm = trim($_POST['post']);
            if ($user_id > 0) {
                if (!empty($_GET['id'])) {
                    if (!empty($comm)) {
                        $query = " UPDATE communication SET "
                                . " text = '" . DB::res($comm) . "' "
                                . "WHERE  user_id =  $user_id  AND  id = " . (int) $_GET['id'];
                    }
                } else {
                    $img = IMAGE::PostImgSave();
                    if (!empty($comm) || $img) {
                        $query = " INSERT INTO communication "
                                . " SET  img = '" . DB::res($img) . "', "
                                . " text = '" . DB::res($comm) . "', "
                                . " user_id =  $user_id, "
                                . " created_at = NOW() ";
                    }
                }
            }
        }
//        var_dump($query);
//        die;
        $error = (!empty($query)) ? DB::q_($query) : 'empty';
        if (!$error) {
            return 'OK';
        }
    }

    public static function items($limit, $status) {
        $data = null;
        $query = "SELECT * FROM communication WHERE `status` != $status ORDER BY id DESC LIMIT $limit";
        $c = DB::q_array_id($query);
        foreach ($c as $id => $vol) {
            $c[$id]['created_at'] = DATA::communication($vol['created_at']);
            $c[$id]['updated_at'] = DATA::communication($vol['updated_at']);
        }
        $data['item_list'] = array_values($c);
        $user_ids = array_unique(self::getUsersId($c));
        $data['users'] = User::getUsers($user_ids);
        return $data;
    }

    public static function delete($id) {
        DB::q_("DELETE FROM communication WHERE id=" . $id);
    }

    public static function Approve($id) {
        DB::q_("UPDATE communication SET `status` = " . self::$allw . "  WHERE id = " . $id);
    }

}
