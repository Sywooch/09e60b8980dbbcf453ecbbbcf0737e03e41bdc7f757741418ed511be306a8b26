<?php

class Home {

    public function get() {
        $data['button'] = [];
        $section = MTD::get();
        $data['button'] = self::button();
//        if ($botton) {
//            foreach ($botton as $key => $vol) {
//                $data['button'][$key] = $vol;
////                $data['button'][$key]['section'] = $section[$data['button'][$key]['section']]['model'];
//            }
//        }
        $data['adv'] = self::adv();

        return $data;
    }

    private static function button() {
        $data = [];
        $query = "SELECT * FROM buttons ORDER BY `order` ASC";
        $kns = DB::q_array($query);
        if (!empty($kns)) {
            $mtd = \MTD::get();
            foreach ($kns as $key => $vol) {
                $section = $mtd[$vol['section']]['home']['db_buttons'];
                if (!empty($vol['image'])) {
                    $vol['image'] = '/' . $vol['image'];
                    if (empty($vol['cat_id'])) {
                        if ($section) {
                            if ($section == 'section_id' && !empty($vol['section_id'])) {
                                $query = "SELECT id FROM " . mb_strtolower($mtd[$vol['section']]['model']) . " WHERE id = " . $vol['section_id'];
                                $sd = DB::q_line($query);
//                            var_dump($query, $sd);
                                if (!empty($sd)) {
                                    $data[$key]['id'] = $vol['section_id'];
                                    $data[$key]['title'] = $vol['title'];
                                    $data[$key]['url'] = '/' . $mtd[$vol['section']]['model'] . '.get?id=' . $vol['section_id'];
                                    $data[$key]['model'] = $mtd[$vol['section']]['model'];
                                    $data[$key]['image'] = $vol['image'];
                                    $data[$key]['telephone'] = '';
                                    $data[$key]['type'] = "item";
                                } else {
                                    self::delete($vol['id']);
                                }
                            } elseif ($section == 'url' && filter_var($vol['url'], FILTER_VALIDATE_URL)) {
                                $data[$key]['id'] = '';
                                $data[$key]['title'] = $vol['title'];
                                $data[$key]['url'] = $vol['url'];
                                $data[$key]['model'] = $mtd[$vol['section']]['model'];
                                $data[$key]['image'] = $vol['image'];
                                $data[$key]['telephone'] = '';
                                $data[$key]['type'] = "url";
                            } elseif ($section == 'telephone' && preg_match("/^[0-9+]+$/", $vol['telephone'])) {
                                $data[$key]['id'] = '';
                                $data[$key]['title'] = $vol['title'];
                                $data[$key]['url'] = '';
                                $data[$key]['model'] = $mtd[$vol['section']]['model'];
                                $data[$key]['image'] = $vol['image'];
                                $data[$key]['telephone'] = $vol['telephone'];
                                $data[$key]['type'] = "tel";
                            }
                        }
                    } else {
                        if ($mtd[$vol['section']]['home']['cat_id']) {
                            $query = "SELECT id FROM " . mb_strtolower($mtd[$vol['section']]['model']) . "_category  WHERE id = " . $vol['cat_id'];
                            $sd = DB::q_line($query);
                            if (!empty($sd)) {
                                $data[$key]['id'] = $vol['cat_id'];
                                $data[$key]['title'] = $vol['title'];
                                $data[$key]['url'] = '/' . $mtd[$vol['section']]['model'] . '.getList?cat_id=' . $vol['cat_id'];
                                $data[$key]['model'] = $mtd[$vol['section']]['model'];
                                $data[$key]['image'] = $vol['image'];
                                $data[$key]['telephone'] = '';
                                $data[$key]['type'] = "cat";
                            } else {
                                self::delete($vol['id']);
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    private static function delete($id) {
        
    }

    private static function adv() {
        $data = [];
        $data = array_merge(self::adv_Poster(), self::adv_Shares());
        return $data;
    }

    private static function adv_Organizations() {
        $data = [];
//    $query = "SELECT * FROM organizations ";
        return $data;
    }

    private static function adv_Shares() {
        $data = [];
        $query = "SELECT * FROM shares WHERE  pin_main > 0 AND published = 1 AND end_at > NOW() ";
        $s = DB::q_array($query);
        if ($s) {
            foreach ($s as $key => $vol) {
                $data[$key]['id'] = $vol['id'];
                $data[$key]['name'] = $vol['name'];
                $data[$key]['image'] = $vol['image'];
                $data[$key]['section'] = 'Shares';
            }
        }
        return $data;
    }

    private static function adv_Poster() {
        $data = [];
        $query = "SELECT * FROM poster WHERE  pin_main > 0 AND published = 1 AND end_at > NOW() ";
        $s = DB::q_array($query);
        if ($s) {
            foreach ($s as $key => $vol) {
                $data[$key]['id'] = $vol['id'];
                $data[$key]['name'] = $vol['name'];
                $data[$key]['image'] = $vol['image'];
                $data[$key]['section'] = 'Poster';
            }
        }
        return $data;
    }

}
