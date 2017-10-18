<?php

class News {
  
  public function getList(){
    $data = null;
    $query = "SELECT n.id, n.category_id , n_d.title , "
            . " (SELECT n_i.image "
            . " FROM news_image n_i "
            . " WHERE n_i.news_id = n.id "
            . " ORDER BY sort_order DESC LIMIT 1) as image , "
            . " n.created_at as `date` "
            . " FROM news n "
            . " LEFT JOIN news_data n_d ON (n_d.nid = n.id) "
            . " WHERE n_d.title != '' "
            . " ORDER BY `date` DESC ";
    return DB::q_array($query);
  }
  
  public function get() {
    if (!empty($_GET['id'])) {
      if ((int) $_GET['id'] > 0) {
       
      }
    }
  }
}
