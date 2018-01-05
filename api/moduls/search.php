<?php

class Search {
                        
    public function __construct() {
        
    }

    public function getList() {
        $data['count'] = 0;
        $data['data'] = [];
        if (!empty($_POST['keyword'])) {
            $keyword = trim($_POST['keyword']);
            if (mb_strlen($keyword) > 2) {
                $keyword = DB::res($keyword);
                $data['data'] = array_merge(self::News($keyword), $data['data']);
                $data['data'] = array_merge(self::Organizations($keyword), $data['data']);
                $data['data'] = array_merge(self::Shares($keyword), $data['data']);
                $data['data'] = array_merge(self::Poster($keyword), $data['data']);
            }
        }
        $data['count'] = count($data['data']);
        $data['mtd'] = MTD::get();
        return $data;
    }

    public function get() {
        $data['count'] = 0;
        $data['data'] = [];
        if (!empty($_POST['keyword'])) {
            $keyword = trim($_POST['keyword']);
            if (mb_strlen($keyword) > 2) {
                $keyword = DB::res($keyword);
                if (!empty($_GET['model'])) {
                    switch ($_GET['model']) {
                        case 'News':
                            $data['data'] = self::News($keyword);
                            break;
                        case 'Organizations':
                            $data['data'] = self::Organizations($keyword);
                            break;
                        case 'Shares':
                            $data['data'] = self::Shares($keyword);
                            break;
                        case 'Poster':
                            $data['data'] = self::Poster($keyword);
                            break;
                    }
                }
            }
        }
        $data['count'] = count($data['data']);
        $data['mtd'] = MTD::get();
        return $data;
    }

    private static function News($keyword) {
        $data = [];
        $query = "SELECT DISTINCT nd.nid as id, nd.title FROM `news_data` nd LEFT JOIN `news` n ON (n.id = nd.nid) 
	WHERE (`title` LIKE '%" . $keyword . "%'
	OR `text` LIKE '%" . $keyword . "%' 
	OR `description` LIKE '%" . $keyword . "%') "
                . " AND n.published = 1";
        $s = DB::q_array($query);
        if (!empty($s)) {
            foreach ($s as $key => $vol) {
                $data[$key]['id'] = $vol['id'];
                $data[$key]['title'] = $vol['title'];
                $data[$key]['desc'] = 'Новости';
                $data[$key]['url'] = '/News.get?id=' . $vol['id'];
                $data[$key]['model'] = 'News';
                $data[$key]['type'] = 'item';
            }
        }
        return $data;
    }

    private static function Organizations($keyword) {
        $data = [];
        $i = 0;
        $query = "SELECT id,name FROM `organizations` "
                . " WHERE (`name` LIKE '%" . $keyword . "%' "
                . " OR `description` LIKE '%" . $keyword . "%') "
                . " AND published = 1 ";
        $s = DB::q_array($query);
        if (!empty($s)) {
            foreach ($s as $key => $vol) {
                $data[$i]['id'] = $vol['id'];
                $data[$i]['title'] = $vol['name'];
                $data[$i]['desc'] = 'Организации';
                $data[$i]['url'] = '/Organizations.get?id=' . $vol['id'];
                $data[$i]['model'] = 'Organizations';
                $data[$i]['type'] = 'item';
                $i++;
            }
        }
        $query = "SELECT id , name FROM `organizations_category` "
                . " WHERE (`id` LIKE '%" . $keyword . "%' "
                . " OR `name` LIKE '%" . $keyword . "%') "
                . " AND active = 1";
        $s = DB::q_array($query);
        if (!empty($s)) {
            foreach ($s as $key => $vol) {
                $data[$i]['id'] = $vol['id'];
                $data[$i]['title'] = $vol['name'];
                $data[$i]['desc'] = 'Организации-категории';
                $data[$i]['url'] = '/Organizations.getList?cat_id=' . $vol['id'];
                $data[$i]['model'] = 'Organizations';
                $data[$i]['type'] = 'cat';
                $i++;
            }
        }
        return $data;
    }

    private static function Shares($keyword) {
        $data = [];
        $i = 0;
        $query = "SELECT id , name FROM `shares` "
                . " WHERE ( `id` LIKE '%" . $keyword . "%' OR `name` LIKE '%" . $keyword . "%' "
                . " OR `description` LIKE '%" . $keyword . "%' ) "
                . " AND published = 1 ";
        $s = DB::q_array($query);
        if (!empty($s)) {
            foreach ($s as $key => $vol) {
                $data[$i]['id'] = $vol['id'];
                $data[$i]['title'] = $vol['name'];
                $data[$i]['desc'] = 'Акции';
                $data[$i]['url'] = '/Shares.get?id=' . $vol['id'];
                $data[$i]['model'] = 'Shares';
                $data[$i]['type'] = 'item';
                $i++;
            }
        }
        return $data;
    }

    private static function Poster($keyword) {
        $data = [];
        $i = 0;
        $query = "SELECT id , name FROM `poster` "
                . " WHERE ( `id` LIKE '%" . $keyword . "%' OR `name` LIKE '%" . $keyword . "%' "
                . " OR `description` LIKE '%" . $keyword . "%' ) "
                . " AND published = 1 ";
        $s = DB::q_array($query);
        if (!empty($s)) {
            foreach ($s as $key => $vol) {
                $data[$i]['id'] = $vol['id'];
                $data[$i]['title'] = $vol['name'];
                $data[$i]['desc'] = 'Афиша';
                $data[$i]['url'] = '/Poster.get?id=' . $vol['id'];
                $data[$i]['model'] = 'Poster';
                $data[$i]['type'] = 'item';
                $i++;
            }
        }
        return $data;
    }

}
