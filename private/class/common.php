<?php
class Common
{
    public static function response($_response = [])
    {
        return json_encode($_response);
    }

    public static function randomString($_length)
    {
        $seed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789_';
        $max = strlen($seed) - 1;
        $string = '';

        for ($i = 0; $i < $_length;
        ++$i) {
            $string .= $seed[intval(mt_rand(0.0, $max))];
        }

        return $string;
    }

    public static function upload($_file)
    {
        if (!isset($_file['error'])
            || is_array($_file['error'])
            || $_file['error'] != UPLOAD_ERR_OK
        ) {
            return null;
        }

        $name = self::randomString(16) . basename($_file["file"]["name"]);

        if (move_uploaded_file(
                $_file["file"]["tmp_name"],
                UPLOADED_IMAGES_PATH . $name
            )
        ) {
            return ['name' => $name];
        } else {
            return null;
        }
    }

    public static function download($_name)
    {
        $file = UPLOADED_IMAGES_PATH . $_name;

        if (file_exists($file)) {
            http_response_code(OK);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            ob_clean();
            flush();
            readfile($file);
        } else {
            return null;
        }
    }

    public static function getheaders()
    {
        if (!function_exists('getallheaders')) {
            $headers = [];

            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[
                        str_replace(' ', '-', ucwords(
                            strtolower(
                                str_replace('_', ' ', substr($name, 5))
                            )
                        ))
                    ] = $value;
                }
            }

            return $headers;
        } else {
            $headers = getallheaders();
        }

        return $headers;
    }

    public static function quickSort($_array, $_sortElement)
    {
        $length = count($_array);

        if ($length <= 1) {
            return $_array;
        } else {
            $pivot = $_array[0];
            $left = $right = [];

            for ($i = 1; $i < $length; $i++) {
                if ($_array[$i][$_sortElement] < $pivot[$_sortElement]) {
                    $left[] = $_array[$i];
                } else {
                    $right[] = $_array[$i];
                }
            }

            return array_merge(
                self::quickSort($left, $_sortElement),
                [$pivot],
                self::quickSort($right, $_sortElement)
            );
        }
    }
}
