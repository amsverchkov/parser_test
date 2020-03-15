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
        if ($ch = curl_init($url)) {
            $params = http_build_query($params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        } else {
            throw new \Exception('CURL ERROR . IMPOSSIBLE TO CONNECT TO' . $url);
        }

    }


}