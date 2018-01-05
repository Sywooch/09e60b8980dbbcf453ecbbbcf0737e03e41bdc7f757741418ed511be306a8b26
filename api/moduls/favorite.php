<?php

class Favorite {

    public function post() {
        $user = User::get();
        if (!empty($_POST['id']) && $user) {
            $id = (int) $_POST['id'];
            $query = "INSERT INTO `favorite` SET user_id = $user[id], item_id = $id ";
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
            $idsw = DB::q_array_key("SELECT item_id FROM `favorite` WHERE user_id = $user[id] ORDER BY id DESC", 'item_id');
            if (!empty($idsw)) {
                $in_id = implode(',', $idsw);
//                var_dump($in_id);die;
//                $query = "SELECT o.*, (SELECT COUNT(id) FROM comments cm WHERE cm.organizations_id = o.id AND status != " . COMMENTS::$hide . ") as comment_count FROM organizations o "
//                        . " WHERE o.id IN ($in_id) "
//                        . " AND o.published = 1";
                $query = "SELECT  DISTINCT o.*, oa.*, "
                        . " (SELECT COUNT(id) FROM comments cm WHERE cm.organizations_id = o.id AND status != " . COMMENTS::$hide . " ) as comment_count , "
                        . " (SELECT number FROM organizations_telephones ot WHERE ot.organization_id = o.id LIMIT 1) as user_telephone FROM organizations o "
                        . " LEFT JOIN organizations_address oa ON (oa.organization_id = o.id) "
                        . " WHERE (o.id IN ($in_id)) "
                        . " AND o.published = 1 ORDER BY o.order ASC";
                $data = DB::q_array($query);
//                var_dump($query);
//                die;
            }
            if (!empty($data)) {
//                var_dump($data);
//                die;
                $ids = [];
                foreach ($data as $key => $vol) {
                    if (!isset($ids[$vol['id']])) {
                        $data[$key]['distance'] = '';
                        $data[$key]['contacts'] = Organizations::item_contacts($vol['id']);
                        if (is_array($data[$key]['contacts'])) {
                            $getContact = Organizations::item_contacts($vol['id']);
                            if (!empty($getContact['telephones'][0])) {
                                $data[$key]['user_telephone'] = preg_replace("/[^0-9+]/", '', $getContact['telephones'][0]);
                            }
                        }
                        if ($vol['latitude'] == 0 || $vol['longitude'] == 0) {
                            $vol['latitude'] = '';
                            $vol['longitude'] = '';
                            $data[$key]['latitude'] = '';
                            $data[$key]['longitude'] = '';
                        }
                        if (is_numeric($vol['latitude']) && is_numeric($vol['longitude'])) {
                            $dist = Distance::getDistance($vol['latitude'], $vol['longitude']);
                            $data[$key]['distance'] = round($dist / 1000, 2) . ' km';
                            $data[$key]['distance_integer'] = (int) $dist;
                        } else {
                            $data[$key]['distance'] = '';
                            $data[$key]['distance_integer'] = '';
                        }
                        $ids[$vol['id']] = TRUE;
                    } else {
                        unset($data[$key]);
                    }
                }
            }
        }
        $data = array_values($data);
        return $data;
    }

}
