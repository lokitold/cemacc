<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author Laptop
 */
class Core_Utils {

    static function arrayAsoccForFirstItem($array, $key = '') {
        $arrayResponse = array();
        if ($key == '') {
            foreach ($array as $index => $data) {
                $arrayResponse[$data[key($data)]][] = $data;
            }
        } else {
            foreach ($array as $index => $data) {
                $arrayResponse[$data[$key]][] = $data;
            }
        }
        return $arrayResponse;
    }

    static function fetchPairs($array = array(), $concat = '', $separador = '') {
        if (!is_array($array))
            return array();
        $dataString = '';
        $arrayResponse = array();
        foreach ($array as $index => $datos) {
            $countConcat = count($concat);
            if (is_array($concat) && $countConcat > 1) {
                $keys = array_keys($datos);
                foreach ($concat as $key2 => $index2) {
                    if ($countConcat == ($key2 + 1)) {
                        $dataString .= $datos[$index2];
                    } else {
                        $dataString .= $datos[$index2] . $separador;
                    }
                }
                $arrayResponse[$datos[$keys[0]]] = $dataString;
                $dataString = '';
            } else {
                $keys = array_keys($datos);
                $arrayResponse[$datos[$keys[0]]] = $datos[$keys[1]];
            }
        }
        return $arrayResponse;
    }
    
    static function fetchPairsTrainer($array = array(), $concat = '', $separador = '') {
        if (!is_array($array))
            return array();
        $dataString = '';
        $arrayResponse = array();
        foreach ($array as $index => $datos) {
            $countConcat = count($concat);
            if (is_array($concat) && $countConcat > 1) {
                $keys = array_keys($datos);
                foreach ($concat as $key2 => $index2) {
                    if ($countConcat == ($key2 + 1)) {
                        $dataString .= $datos[$index2];
                    } else {
                        $dataString .= $datos[$index2] . $separador;
                    }
                }
                $arrayResponse[$datos[$keys[0]]] = $dataString;
                $dataString = '';
            } else {
                $keys = array_keys($datos);
                $arrayResponse[$datos[$keys[0]]] = $datos[$keys[1]] . " " . $datos[$keys[2]];
            }
        }
        return $arrayResponse;
    }

    static function parseUrlVimeo($uri) {
        $curl = curl_init('http://vimeo.com/api/oembed.json?url=' . $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($curl);
        if ($result == '404 Not Found') {
            return FALSE;
        } else {
            return $result;
        }
    }

    static function validateUrlVimeo($uri) {
        $result = array();
        $response = self::parseUrlVimeo($uri);
        if ($response != FALSE) {
            $result = Zend_Json::decode($response);
            $result['message'] = '';
            $result['html'] = '<iframe width="590" height="332" src="http://player.vimeo.com/video/' . $result['video_id'] . '" frameborder="0" allowfullscreen></iframe>';
            $result['validate'] = TRUE;
            $result['type'] = 'Vimeo';
        } else {
            $result['message'] = 'no se encontro la ruta';
            $result['validate'] = FALSE;
        }
        return $result;
    }

    static function convertUrlQuery($query) {
        if ($query != '') {
            $queryParts = explode('&', $query);
            $params = array();
            foreach ($queryParts as $param) {
                $item = explode('=', $param);
                $params[$item[0]] = $item[1];
            }
            return $params;
        }
    }

    static function validateUrlYoutube($uri = '') {
        $arrayReturn = array();
        if ($uri == '') {
            $arrayReturn['validate'] = false;
            return $arrayReturn;
        }
        $array = parse_url($uri);
        if (isset($array['query']))
            $array = self::convertUrlQuery($array['query']);

        $yt = new Zend_Gdata_YouTube();
        //$objUri = Zend_Uri::check($uri);
        //exit;
        $arrayReturn['validate'] = TRUE;

        if (Zend_Uri::check($uri)) {
            try {
                $videoEntry = $yt->getVideoEntry($array['v']);
                $obj = new ReflectionClass($videoEntry);
                // print_r($obj->getMethods());
                $arrayReturn['video'] = $videoEntry->getVideoTitle();
                $arrayReturn['videoID'] = $videoEntry->getVideoId();
                $arrayReturn['updated'] = $videoEntry->getUpdated();
                $arrayReturn['description'] = $videoEntry->getVideoDescription();
                $arrayReturn['thumbnails'] = $videoEntry->getVideoThumbnails();
                $arrayReturn['thumbnail_url'] = $arrayReturn['thumbnails'][0]['url'];
                $arrayReturn['source'] = $videoEntry->getVideoResponsesLink();
                $arrayReturn['category'] = $videoEntry->getVideoCategory();
                $arrayReturn['tags'] = implode(", ", $videoEntry->getVideoTags());
                $arrayReturn['watchPage'] = $videoEntry->getVideoWatchPageUrl();
                $arrayReturn['flashPlayerUrl'] = $videoEntry->getFlashPlayerUrl();
                $arrayReturn['duration'] = $videoEntry->getVideoDuration();
                $arrayReturn['viewCount'] = $videoEntry->getVideoViewCount();
                $arrayReturn['message'] = $videoEntry->getVideoViewCount();
                $arrayReturn['html'] = '<iframe width="590" height="332" src="' . $arrayReturn['flashPlayerUrl'] . '" frameborder="0" allowfullscreen></iframe>';
                $arrayReturn['type'] = 'Youtube';
            } catch (Exception $e) {
                $arrayReturn['validate'] = FALSE;
                $arrayReturn['message'] = $e->getMessage();
            }
        } else {
            $arrayReturn['validate'] = FALSE;
            $arrayReturn['message'] = 'La ruta no es valida';
        }

        return $arrayReturn;
    }

    static function getRandomString($length = 10, $encrypt = 1) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return ($encrypt) ? md5($str) : $str;
    }

    static function fromSecondAndHours($horasData) {
        $segundos = 0;
        /* $horasData = array('02:20:30', '05:10:10', '00:00:10'); */
        foreach ($horasData as $value) {
            $arrayValues = explode(':', $value);
            $segundos = $segundos + ((int) $arrayValues[0]) * 3600 + ((int) $arrayValues[1]) * 60 + (int) $arrayValues[2];
        }
        $minutos = $segundos / 60;
        $horas = floor($minutos / 60);
        $minutos2 = $minutos % 60;
        $segundos_2 = $segundos % 60 % 60 % 60;
        if ($minutos2 < 10)
            $minutos2 = '0' . $minutos2;
        if ($segundos_2 < 10)
            $segundos_2 = '0' . $segundos_2;

        if ($segundos < 60) { /* segundos */
            $resultado = '00:00:' . round($segundos);
        } elseif ($segundos > 60 && $segundos < 3600) {/* minutos */
            $resultado = '00:' . $minutos2 . ':' . $segundos_2;
        } else {/* horas */
            $resultado = $horas . ':' . $minutos2 . ':' . $segundos_2 . ' Horas';
        }
        return $resultado;
    }

    static function calcularDiferenciaTiempoConActual($fecha) {
        $fecha1 = new DateTime($fecha);
        $fecha2 = new DateTime(date('Y-m-d H:i:s'));
        $fecha = $fecha1->diff($fecha2);
        $horas = (int) (((int) $fecha->format('%d')) * 60 + $fecha->format('%H'));
        return $horas . ':' . $fecha->format('%i') . ':' . $fecha->format('%s');
    }

    static function moveValueArrayByIndex(array $array, $from = null, $to = null) {
        if (null === $from) {
            $from = count($array) - 1;
        }

        if (!isset($array[$from])) {
            throw new Exception("Offset $from does not exist");
        }

        if (array_keys($array) != range(0, count($array) - 1)) {
            throw new Exception("Invalid array keys");
        }

        $value = $array[$from];
        unset($array[$from]);

        if (null === $to) {
            array_push($array, $value);
        } else {
            $tail = array_splice($array, $to);
            array_push($array, $value);
            $array = array_merge($array, $tail);
        }

        return $array;
    }

    static function numberToColumnName($number) {
        $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $abc_len = strlen($abc);
        $result = "";
//        $tmp = $number;
        while ($number > $abc_len) {
            $remainder = $number % $abc_len;
            $result = $abc[$remainder - 1] . $result;
            $number = floor($number / $abc_len);
        }
        return $abc[$number - 1] . $result;
    }
    
    static function logConsole($params){
        $logger = new Zend_Log(new Zend_Log_Writer_Firebug());
        $logger->log(print_r($params,TRUE), Zend_Log::INFO);
    }

}

?>
