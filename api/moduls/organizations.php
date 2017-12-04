<?php

class Organizations {

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
        $data['category_list'] = CATEGORY::get('organizations', $cat_id);
        if (!empty($data['category_list'])) {
            $data['item_list'] = [];
        } else {
            $data['item_list'] = self::itemList($cat_id);
        }
        return $data;
    }

    private static function categoryList($cat_id = null) {
        $data = [];
        $query = null;
        if ($cat_id) {
            $cat = DB::q_line("SELECT * FROM organizations_category WHERE id = " . $cat_id);
            if ($cat) {
                $query = "SELECT * FROM organizations_category WHERE root = $cat[id] AND lvl = " . ($cat['lvl'] + 1) . " ";
            }
        } else {
            $query = "SELECT * FROM organizations_category WHERE lvl = 0";
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
            $query = "SELECT  DISTINCT o.*, oa.*, "
                    . " (SELECT COUNT(id) FROM comments cm WHERE cm.organizations_id = o.id ) as comment_count , "
                    . " (SELECT number FROM organizations_telephones ot WHERE ot.organization_id = o.id LIMIT 1) as user_telephone FROM organizations o "
                    . " LEFT JOIN organizations_address oa ON (oa.organization_id = o.id) "
                    . " WHERE (o.category_id  LIKE ('%" . $cat_id . "%')) "
                    . " AND o.published = 1";
        }
        if ($query) {
            $data = DB::q_array($query);
        }
        $ids = [];
        if (!empty($data)) {
            foreach ($data as $key => $vol) {
                if (!isset($ids[$vol['id']])) {
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
                    $data[$key]['user_telephone'] = preg_replace("/[^0-9+]/", '', $data[$key]['user_telephone']);
                    $data[$key]['working_days'] = $vol['working_days'] . ' ' . $vol['working_hours'];

                    $ids[$vol['id']] = TRUE;
                } else {
                    unset($data[$key]);
                }
            }
        }
        $data = array_values($data);
        return $data;
    }

    private static function reklama() {
        $data = [];
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
                } else {
                    return [];
                }
            }
            $data['id'] = $id;
            $data['title'] = '';
            $data['url'] = $url;
            $data['model'] = $model;
            $data['image'] = $vol['image'];
            $data['telephone'] = $tel;
            $data['type'] = $type;
        }
        return $data;
//        return ['name' => 'test',
//            'img' => '/uploads/images/ram/2016-06-24_21-35-50.png',
//            'url' => 'https://dunpal.com',
//            'tel' => '+799999999'
//        ];
    }

    public function get() {
        $data = [];
        $id = null;
        if (!empty($_GET['id'])) {
            if ((int) $_GET['id'] > 0) {
                $id = (int) $_GET['id'];
            }
        }
        $data['item'] = self::getItem($id);
        return $data;
    }

    private static function getItem($id) {
        $data = null;
        if ($id) {
            $info = self::item_info($id);
            if ($info) {
//                var_dump($info);die;
                if (empty($info['image'])) {
                    $info['image'] = '/uploads/images/def_Organizations.png';
                }
//                News::comment(null, $id);
                $comments = COMMENTS::execute('organizations_id', $id);
                $contacts = self::item_contacts($id);
//                $comments = self::item_comments($id);
                ######
                $data['info'] = $info;
                $info['go'] = 17;
                $data['contacts'] = $contacts;

                if (!empty($contacts['telephones'][0])) {
                    $data['info']['user_telephone'] = preg_replace("/[^0-9+]/", '', $contacts['telephones'][0]);
                }
                $data['comments'] = $comments;
                $user_ids = array_unique(Communication::getUsersId($data['comments']));
                $data['users'] = User::getUsers($user_ids);
            }
        }
        return $data;
    }

//    private static function item_comments($id) {
//        $query = "SELECT id, "
//                . " `comment`, "
//                . " user_id, "
//                . " created_at, "
//                . " updated_at "
//                . " FROM `comments` "
//                . " WHERE organizations_id = " . $id . " "
//                . " ORDER BY id DESC";
//        return DB::q_array($query);
//    }

    public static function item_contacts($id) {
        $data['address'] = DB::q_array("SELECT * FROM organizations_address WHERE organization_id = " . $id);
        if (!empty($data['address'])) {
            foreach ($data['address'] as $key => $vol) {
                $data['address'][$key]['working_days'] = $vol['working_days'] . ' ' . $vol['working_hours'];
            }
        }

        $data['telephones'] = DB::q_array_key("SELECT number FROM organizations_telephones WHERE number !='' AND organization_id = " . $id, 'number');

        return $data;
    }

    private static function item_info($id) {
        $query = "SELECT * FROM organizations WHERE id = " . $id;
        return DB::q_line($query);
    }

}
