<?php

class Communication {

    public static $new = 0;
    public static $update = 1;
    public static $hide = 2;

    public function getList() {
        $data = null;
        $query = "SELECT * FROM communication WHERE `status` != " . self::$hide . " ORDER BY id DESC";
        $c = DB::q_array_id($query);
//        if ($c) {
//            $id = array_keys($c);
//            $in_id = implode(',', $id);
//            $query = "SELECT * FROM comments WHERE communication_id IN ( $in_id ) AND `status` != " . self::$hide . " ORDER BY id DESC ";
//            $cc = DB::q_array($query);
//            if ($cc) {
//                foreach ($cc as $vol) {
//                    $c[$vol['id']]['comments'][] = $vol;
//                }
//            }
//        }
        $data['list'] = array_values($c);
        $user_ids = array_unique(self::getUsersId($c));
        $data['users'] = User::get($user_ids);
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
                $data['users'] = User::get($user_ids);
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
        $query = null;
        $user = User::get();
        if ($user) {
            $user_id = (int) $user['id'];
            @$comm = trim($_POST['post']);
            if ($user_id > 0) {
                if (!empty($comm)) {
                    if (!empty($_GET['id'])) {
                        $query = " UPDATE communication SET "
                                . " text = '" . DB::res($comm) . "' WHERE  user_id =  $user_id  AND  id = " . (int) $_GET['id'];
                    } else {
                        $query = " INSERT INTO communication "
                                . " SET  text = '" . DB::res($comm) . "', user_id =  $user_id, created_at = NOW() ";
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
