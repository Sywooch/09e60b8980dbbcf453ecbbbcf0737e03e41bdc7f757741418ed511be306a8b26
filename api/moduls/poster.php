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
                if (self::cheker($vol['start_at'], $vol['end_at'])) {
                    $at = DATA::poster($vol['start_at'], $vol['end_at']);
                    $item[$key]['at'] = $at;
                    $item[$key]['description'] = nl2br($item[$key]['description']);
                    unset($item[$key]['updated_at']);
                    unset($item[$key]['created_at']);
                    unset($item[$key]['end_at']);
                    unset($item[$key]['start_at']);
                } else {
                    unset($item[$key]);
                }
            }
        }
        $data['category'] = $category;
        $data['data'] = $item;
        return $data;
    }

    private static function cheker($start, $end) {
        if (DATA::posterCheker($start, $end)) {
            return TRUE;
        }
    }

    public function get() {
        if (!empty($_GET['id'])) {
            if ((int) $_GET['id'] > 0) {
                $query = "SELECT * FROM poster "
                        . "WHERE published = '1' "
                        . " AND id = " . (int) $_GET['id'];
                $vol = DB::q_line($query);
                if ($vol) {
                    $at = DATA::poster($vol['start_at'], $vol['end_at']);
                    $vol['at'] = $at;
                    $vol['description'] = nl2br($vol['description']);
                    unset($vol['updated_at']);
                    unset($vol['created_at']);
                    unset($vol['end_at']);
                    unset($vol['start_at']);
                } else {
                    $vol = [];
                }
                return $vol;
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
                . "ORDER BY id ASC";
        $top = DB::q_array($query);

        $query = "SELECT * FROM poster "
                . " WHERE published = '1' "
                . " AND category_id = $id "
                . " AND pin_filter != 1 "
                . " ORDER BY end_at ASC";
        $sec = DB::q_array($query);
        return array_merge(array_values($top), array_values($sec));
    }

    private function listAll() {
        $data = null;
        $query = "SELECT * FROM poster "
                . "WHERE published = '1' "
                . " AND pin_poster = 1 "
                . " ORDER BY  id ASC";
        $top = DB::q_array($query);

        $query = "SELECT * FROM poster "
                . " WHERE published = '1' "
                . " AND pin_poster != 1 "
                . " ORDER BY end_at ASC";
        $sec = DB::q_array($query);

        return array_merge(array_values($top), array_values($sec));
    }

}
