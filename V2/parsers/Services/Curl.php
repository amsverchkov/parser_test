<?php
namespace parsers\Services;


class Curl
{
    /**
     * Получает страницу (html код)
     * @param string $url урл источника для получения
     * @param string $method метод для получения страницы
     * @param array $params массив настроек
     * @return string
     * @throws \Exception
     */
    public static function getPage($url, $method = 'get', $params = []) :string
    {
        $params = http_build_query($params);
        if ($ch = curl_init($url . '?' . $params)) {

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);

            if ($method == 'post') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }

            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        } else {
            throw new \Exception('CURL ERROR . IMPOSSIBLE TO CONNECT TO' . $url);
        }

    }


}