<?php

class Favorite {

    public function post() {
        $user = User::get();
        if (!empty($_POST['id']) && $user) {
            $id = (int) $_POST['id'];
            $query = "INSERT INTO `favorite` SET user_id=$user[id], item_id = $id ";
//            var_dump($query);die;
            $error = DB::q_($query);
            if (!$error) {
                return 'OK';
            } else {
                return ['error' => ['code' => 'f-2', 'message' => 'internal error']];
            }
        }
    }

    public function delete() {
        $user = User::get();
        if (!empty($_POST['id']) && $user) {
            $id = (int) $_POST['id'];
            $error = DB::q_("DELETE FROM `favorite` WHERE user_id=" . $user['id'] . " AND item_id = $id ");
            if (!$error) {
                return 'OK';
            } else {
                return ['error' => ['code' => 'f-1', 'message' => 'internal error']];
            }
        }
    }

    public function getList() {
        $data = [];
        $user = User::get();
        if ($user) {
            $ids = DB::q_array_key("SELECT item_id FROM `favorite` WHERE user_id = $user[id] ORDER BY id DESC", 'item_id');
            if (!empty($ids)) {
                $in_id = implode(',', $ids);
//                var_dump($in_id);die;
                $query = "SELECT o.*, (SELECT COUNT(id) FROM comments cm WHERE cm.organizations_id = o.id ) as comment_count FROM organizations o "
                        . " WHERE o.id IN ($in_id) "
                        . " AND o.published = 1";
                $data = DB::q_array($query);
//                var_dump($query);
//                die;
            }
            if (!empty($data)) {
//                var_dump($data);
//                die;
                foreach ($data as $key => $vol) {
                    $data[$key]['distance'] = '';
                    $data[$key]['contacts'] = Organizations::item_contacts($vol['id']);
                    if (is_array($data[$key]['contacts'])) {
//                        foreach ($data[$key]['contacts'] as $vol) {
//                            
//                        }
                        $getContact = Organizations::item_contacts($vol['id']);

                        if (!empty($getContact['telephones'][0])) {
//                            var_dump($getContact['telephones'][0], $key);
//                            die;
                            $data[$key]['user_telephone'] = preg_replace("/[^0-9+]/", '', $getContact['telephones'][0]);
                        }
                    }
                    if (@is_numeric($vol['latitude']) && is_numeric($vol['longitude'])) {
                        $data[$key]['distance'] = Distance::getDistance($vol['latitude'], $vol['longitude']);
                    } else {
                        
                    }
                }
            }
        }
//        var_dump($data);die;
        return $data;
    }

}
