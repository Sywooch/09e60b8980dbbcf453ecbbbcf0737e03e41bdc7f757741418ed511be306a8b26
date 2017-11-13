<?php

class Poster {

    public function getList() {
        $data = null;
        $category = $this->listFiltr();
        if (!empty($_GET['category_id'])) {
            $category_id = (int) $_GET['category_id'];
            $item = $this->listByCategory($category_id);
        } else {
            $item = $this->listAll();
        }
        if (!empty($item)) {
            foreach ($item as $key => $vol) {
                $at = DATA::poster($vol['start_at'], $vol['end_at']);
                $item[$key]['at'] = $at;
                unset($item[$key]['updated_at']);
                unset($item[$key]['created_at']);
                unset($item[$key]['end_at']);
                unset($item[$key]['start_at']);
            }
        }
         $data['category'] = $category;
        $data['data'] = $item;
        return $data;
    }

    public function get() {
        if (!empty($_GET['id'])) {
            if ((int) $_GET['id'] > 0) {
                $query = "SELECT * FROM poster "
                        . " WHERE published = '1' "
                        . " AND id = " . (int) $_GET['id']
                        . " AND start_at < NOW() "
                        . " AND end_at > NOW() ";
                return DB::q_line($query);
            }
        }
    }

    private function listFiltr() {
        return DB::q_array("SELECT id,title,image FROM filters WHERE published = 1 AND category_id = 1");
    }

    private function listByCategory($id) {
        $data = null;
        $query = "SELECT * FROM poster "
                . "WHERE published = '1' "
                . "AND category_id = $id "
                . "AND pin_filter = 1 "
//            . "AND start_at < NOW() "
                . "AND end_at > NOW() "
                . "ORDER BY id ASC";
        $top = DB::q_array($query);

        $query = "SELECT * FROM poster "
                . " WHERE published = '1' "
                . " AND category_id = $id "
                . " AND pin_filter != 1 "
                . " AND start_at < NOW() "
                . " AND end_at > NOW() "
                . " ORDER BY end_at DESC";
        $sec = DB::q_array($query);

        return array_merge((array) $top, (array) $sec);
    }

    private function listAll() {
        $data = null;
        $query = "SELECT * FROM poster "
                . "WHERE published = '1' "
                . " AND pin_poster = 1 "
//            . " AND start_at < NOW() "
                . " AND end_at > NOW() "
                . " ORDER BY id ASC";
        $top = DB::q_array($query);

        $query = "SELECT * FROM poster "
                . " WHERE published = '1' "
                . " AND pin_poster != 1 "
//            . " AND start_at < NOW() "
                . " AND end_at > NOW() "
                . " ORDER BY end_at DESC";
        $sec = DB::q_array($query);

        return array_merge((array) $top, (array) $sec);
    }

}
