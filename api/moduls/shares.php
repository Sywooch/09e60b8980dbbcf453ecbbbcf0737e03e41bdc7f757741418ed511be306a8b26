<?php

class Shares {

    private static function ddd($string) {
//        $string = strip_tags($string);
// обрежем его на определённое количество символов:
        $string = mb_substr($string, 0, 23);

// удалим в конце текста восклицательй знак, запятую, точку или тире:
        $string = rtrim($string, "!,.-");

// находим последний пробел, устраняем его и ставим троеточие:
        $string = substr($string, 0, strrpos($string, ' '));
        return $string;
    }

    public function getList() {
        $data = null;
        $category = $this->listFiltr();
        if (!empty($_GET['category_id'])) {
            $category_id = (int) $_GET['category_id'];
            $item = $this->listByCategory($category_id);
        } else {
            $item = $this->listAll();
        }
//        var_dump($item);die;
        if (!empty($item)) {
            foreach ($item as $key => $vol) {
                $at = DATA::poster($vol['start_at'], $vol['end_at']);
                $item[$key]['at'] = $at;
//                $item[$key]['description'] = self::ddd($item[$key]['description']);
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
                $query = "SELECT * FROM shares "
                        . " WHERE published = '1' "
                        . " AND id = " . (int) $_GET['id'];

                $vol = DB::q_line($query);
                if ($vol) {
                    $at = DATA::poster($vol['start_at'], $vol['end_at']);
                    $vol['at'] = $at;
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
        return DB::q_array("SELECT id,title,image FROM filters WHERE published = 1 AND category_id = 0");
    }

    private function listByCategory($id) {
        $data = null;
        $query = "SELECT * FROM shares "
                . " WHERE published = '1' "
                . " AND category_id = $id "
                . " AND pin_filter = 1 "
//                . " AND start_at < NOW() "
//                . " AND end_at > NOW() "
                . " ORDER BY id ASC";
        $top = DB::q_array($query);

        $query = "SELECT * FROM shares "
                . " WHERE published = '1' "
                . " AND category_id = $id "
                . " AND pin_filter != 1 "
//                . " AND start_at < NOW() "
//                . " AND end_at > NOW() "
                . " ORDER BY end_at ASC";
        $sec = DB::q_array($query);

        return array_merge((array) $top, (array) $sec);
    }

    private function listAll() {
        $data = null;
        $query = "SELECT * FROM shares "
                . " WHERE published = '1' "
                . " AND pin_poster = 1 "
//                . " AND start_at < NOW() "
//                . " AND end_at > NOW() "
                . " ORDER BY id ASC";
        $top = DB::q_array($query);

        $query = "SELECT * FROM shares "
                . " WHERE published = '1' "
                . " AND pin_poster != 1 "
//                . " AND start_at < NOW() "
//                . " AND end_at > NOW() "
                . " ORDER BY end_at ASC";
        $sec = DB::q_array($query);

        return array_merge((array) $top, (array) $sec);
    }

}
