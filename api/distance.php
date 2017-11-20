<?php

define('EARTH_RADIUS', 6372795);

class Distance {

    // Радиус земли


    /*
     * Расстояние между двумя точками
     * $φA, $λA - широта, долгота 1-й точки,
     * $φB, $λB - широта, долгота 2-й точки
     * Написано по мотивам http://gis-lab.info/qa/great-circles.html
     * Михаил Кобзарев <mikhail@kobzarev.com>
     *
     */
    public static function calculateTheDistance($φA, $λA, $φB, $λB) {

        // перевести координаты в радианы
        $lat1 = $φA * M_PI / 180;
        $lat2 = $φB * M_PI / 180;
        $long1 = $λA * M_PI / 180;
        $long2 = $λB * M_PI / 180;

        // косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

        // вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        //
        $ad = atan2($y, $x);
        $dist = $ad * EARTH_RADIUS;

        return $dist;
    }

    public static function getDistance($x = 180, $y = 180) {
        $xx = 99999;
        $yy = 99999;
        if (!empty($_GET['x']) && !empty($_GET['y'])) {
            $xx = (float) $_GET['x'];
            $yy = (float) $_GET['y'];
        } else {
            $header = getallheaders();
            if (!empty($header['X']) && !empty($header['Y'])) {
                $xx = (float) $header['X'];
                $yy = (float) $header['Y'];
            }
        }
        if (($xx > -90 && $xx < 90) && ($yy > -90 && $yy < 90)) {
//            var_dump($xx, $yy, (float)$x, (float)$y);die;
            $dis = self::calculateTheDistance($xx, $yy, (float) $x, (float) $y);
            if (is_numeric($dis)) {
//                return round($dis / 1000, 2) . ' km';
                return $dis;
            }
        }
        return '';
    }

}
