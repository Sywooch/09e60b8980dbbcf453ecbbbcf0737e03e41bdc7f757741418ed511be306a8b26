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
        $data['category_list'] = self::categoryList($cat_id);
        $data['item_list'] = self::itemList($cat_id);
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
            $query = "SELECT o.*, oa.* FROM organizations o "
                    . " LEFT JOIN organizations_address oa ON (oa.organization_id = o.id) "
                    . " WHERE (o.category_id  LIKE ('%," . $cat_id . "') OR o.category_id = '$cat_id') "
                    . " AND o.published = 1";
        }
        if ($query) {
            $data = DB::q_array($query);
        }
        return $data;
    }

    private static function reklama() {
        return ['name' => 'test',
            'img' => '/uploads/images/ram/2016-06-24_21-35-50.png',
            'url' => 'https://dunpal.com',
            'tel' => '+799999999'
        ];
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
                News::comment(null, $id);
                $contacts = self::item_contacts($id);
                $comments = self::item_comments($id);
                ######
                $data['info'] = $info;
                $data['contacts'] = $contacts;
                $data['comments'] = $comments;
            }
        }
        return $data;
    }

    private static function item_comments($id) {
        $query = "SELECT id, "
                . " `comment`, "
                . " user_id, "
                . " created_at, "
                . " updated_at "
                . " FROM `comments` "
                . " WHERE organizations_id = " . $id . " "
                . " ORDER BY id DESC";
        return DB::q_array($query);
    }

    private static function item_contacts($id) {
        $data['address'] = DB::q_array("SELECT * FROM organizations_address WHERE organization_id = " . $id);
        $data['images'] = DB::q_array("SELECT * FROM organizations_images WHERE organization_id = " . $id . " ORDER BY  sort_order DESC");
        $data['sites'] = DB::q_array("SELECT * FROM organizations_sites WHERE organization_id = " . $id);
        $data['telephones'] = DB::q_array("SELECT * FROM organizations_telephones WHERE organization_id = " . $id);
        return $data;
    }

    private static function item_info($id) {
        $query = "SELECT * FROM organizations WHERE id = " . $id;
        return DB::q_line($query);
    }

}
