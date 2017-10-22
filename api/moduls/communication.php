<?php

class Communication {

    public function getList() {
        $data = null;
        $query = "SELECT * FROM communication ORDER BY id DESC";
        $c = DB::q_array_id($query);
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

}
