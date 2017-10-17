<?php

header('Content-Type: application/json; charset=utf-8');

function getNearestCitys($citys, $x, $y) {
  $data = null;
  foreach ($citys as $city => $vol) {
    $data[$city] = sqrt(pow($x - $vol['x'], 2) + pow($y - $vol['y'], 2));
  }
  asort($data);
  $sort = array_slice($data, 0, 2);
  foreach ($sort as $city => $vol) {
    $citys[$city]['index'] = $city;
    unset($citys[$city]['dbname']);
    unset($citys[$city]['api']);
    $ne[$city] = $citys[$city];
  }
  return $ne;
}

function city($citys, array $near = []) {
  $data = NULL;
  foreach ($citys as $city => $vol) {
    $sort_key[$city] = $vol['name'];
  }
  asort($sort_key);
  foreach ($sort_key as $city => $vol) {
    $citys[$city]['index'] = $city;
    unset($citys[$city]['dbname']);
    unset($citys[$city]['api']);
    $data[$city] = $citys[$city];
  }

  return array_diff_key($data, $near);
}

##### END FUNCTION ######
$near = [];
$citys = yaml_parse_file(__DIR__ . '/../framework/config/domain.yml');
$x_y = null;
if (!empty($_GET['x']) && !empty($_GET['y'])) {
  $x = floatval($_GET['x']);
  $y = floatval($_GET['y']);
  if ($x > -90 && $x < 90 && $y > -90 && $y < 90) {
    $near = getNearestCitys($citys, $x, $y);
    $data['near_city'] = array_values($near);
  }
}
$city = city($citys, $near);
$data['city'] = array_values($city);

print json_encode($data, JSON_UNESCAPED_UNICODE);
//var_dump($data);


