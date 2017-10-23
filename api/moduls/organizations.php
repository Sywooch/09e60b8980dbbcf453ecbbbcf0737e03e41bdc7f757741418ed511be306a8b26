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
                    . " WHERE (o.category_id  LIKE ('%," . $cat_id . "') OR o.category_id = '$cat_id') AND o.published = 1";
        }
        if ($query) {
            $data = DB::q_array($query);
        }
        return $data;
    }

    private static function reklama() {
        return ['name' => 'test', 'img' => '/uploads/images/ram/2016-06-24_21-35-50.png', 'url' => 'https://dunpal.com'];
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
        if($id){
            
        }
    }

    private static function _comments($id) {
        
    }

}
