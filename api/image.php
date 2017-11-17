<?php

require(__DIR__ . '/../features/imageresize/ImageResize.php');

class IMAGE extends ImageResize {

    private static $config;
    private static $resize = 250;

    public function __construct($filename = null) {
        return parent::__construct($filename);
    }

    public static function ProfileImgSave($user = null) {
        $data = null;
        if ($user) {
            $file = self::fileCollector();
            if ($file) {
                $file_name = $user['id'] . '_' .
                        md5($user['hash']) . '.' .
                        $file->type;
                $file_path_base = '/uploads/p_images/' . $file_name;
                $file_path = __DIR__ . '/../public_html' . $file_path_base;

                $file->save($file_path);
                if (file_exists($file_path)) {
                    $query = "UPDATE `user` SET photo_250 = '" . $file_path_base . "' WHERE id = " . $user['id'];
                    $error = USER::q_($query);
                    if ($error) {
                        $data['error']['code'] = 'upis';
                    } else {
                        $data = $file_path_base;
                    }
                }
            }
        }
        return $data;
    }

    private static function fileCollector($n = 1) {
        $data = null;
        $fa = array_shift($_FILES);
        if (!empty($fa)) {
            if (is_array($fa['name'])) {
                
            } else {
                $data = self::fileHandler($fa);
            }
        }
        return $data;
    }

    private static function fileHandler($file) {
        $data = null;
        try {
            $obj = new self($file['tmp_name']);
            $type = null;
            switch (image_type_to_mime_type($obj->source_type)) {
                case "image/jpeg":
                    $type = 'jpeg';
                    break;
                case "image/png":
                    $type = 'png';
                    break;
//        case "image/bmp":
//          echo "Image is a bmp";
//          break;
            }
            if ($type) {
                $obj->resizeToBestFit(self::$resize, self::$resize);
                $obj->source = $file;
                $obj->type = $type;
//        $obj->save('/home/admin/web/100081.ooogoroda.mobi/public_html/aa');
                $data = $obj;
            }
        } catch (Exception $e) {
            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
        }

        return $data;
    }

    public static function CommentImgSave() {
        return self::ImgSave('comment',150);
    }

    public static function PostImgSave() {
        return self::ImgSave('post',150);
    }

    public static function ImgSave($path = 'def', $resize = 1200) {
        $data = null;
        self::$resize = $resize;
        $file = self::fileCollector();
        if ($file) {
            $file_name = date("Y-m-d_H_i_s") . '_' .
                    md5($file) . '.' .
                    $file->type;
            if (!is_dir(__DIR__ . '/../public_html/uploads/images/' . $path . '/')) {
                mkdir(__DIR__ . '/../public_html/uploads/images/' . $path . '/');
            }
            $file_path_base = '/uploads/images/' . $path . '/' . $file_name;
            $file_path = __DIR__ . '/../public_html' . $file_path_base;

            $file->save($file_path);
            if (file_exists($file_path)) {
                $data = $file_path_base;
            }
        }
        return $data;
    }

}
