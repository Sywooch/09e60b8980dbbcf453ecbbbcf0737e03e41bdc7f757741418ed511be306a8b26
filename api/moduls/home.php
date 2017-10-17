<?php

class Home {

  public function get() {
    $data['button'] = [];
    $section = MTD::get();
    $botton = self::button();
    if ($botton) {
      foreach ($botton as $key => $vol) {
        $data['button'][$key] = $vol;
        $data['button'][$key]['section'] = $section[$data['button'][$key]['section']]['model'];
      }
    }
    $data['adv'] = self::adv();

    return $data;
  }

  private static function button() {
    $query = "SELECT * FROM buttons ORDER BY `order` ASC";
    return DB::q_array($query);
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
