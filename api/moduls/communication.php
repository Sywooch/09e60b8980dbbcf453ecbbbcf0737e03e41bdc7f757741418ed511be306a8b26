<?php

class Communication {

    public function getList() {
        $data = null;
        $query = "SELECT * FROM communication ORDER BY id DESC";
        $c = DB::q_array($query);
        if ($c) {
            $id = array_keys($c);
            $in_id = implode(',', $id);
            $query = "SELECT * FROM communication_comments WHERE c_id IN ( $in_id ) ORDER BY id DESC ";
            $cc = DB::q_array($query);
            if ($cc) {
                foreach ($cc as $vol) {
                    $c[$vol['c_id']]['comments'][] = $vol;
                }
            }
        }
        $data['list'] = $c;
        $user_ids = array_unique(self::getUsersId($c));
        $data['users'] = User::get($user_ids);
        return $data;
    }

    private static function getUsersId($array) {
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

    public function comment() {
        $user = User::get();
        if ($user && !empty($_POST['comment'])) {
            $user_id = (int) $user['id'];
            $comm = trim($_POST['comment']);
            if ($user_id > 0 && !empty($comm)) {
                if (!empty($_GET['id'])) {
                    $query = " INSERT INTO communication_comments "
                            . " SET c_id = " . (int) $_GET['id'] . ", "
                            . " text = '" . DB::res($comm) . "', user_id =  $user_id, created_at = NOW() ";
                } else {
                    $query = " INSERT INTO communication "
                            . " SET  text = '" . DB::res($comm) . "', user_id =  $user_id, created_at = NOW() ";
                }
                $error = DB::q_($query);
                if (!$error) {
                    return 'OK';
                }
            }
        }
    }

}
