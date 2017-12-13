<?php

class CATEGORY {

    public static function get($name, $id = null) {
        $data = [];
        $query = "SELECT * FROM " . $name . "_category WHERE active = 1 ORDER BY root ASC , lft ASC";
        $cats = DB::q_array($query);
        if (!empty($cats)) {
            $lvl = 0;
            foreach ($cats as $key => $vol) {
                if ($vol['lvl'] == 0 && $id == null) {
                    $data[] = $vol;
                } elseif ($id) {

                    if ($id == $vol['id']) {
                        $lvl = (int) $vol['lvl'] + 1;
                    }
                }
                if ($lvl > 0) {
                    if ($id != $vol['id']) {
                        if (($lvl) == $vol['lvl']) {
                            $data[] = $vol;
                        } else {
                            $lvl = -1;
                        }
                    }
                }
            }
        }
        return $data;
    }

}
