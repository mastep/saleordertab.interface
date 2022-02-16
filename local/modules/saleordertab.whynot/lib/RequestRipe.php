<?php

namespace Module\CustomTab;

use \Bitrix\Main\Web\HttpClient;

/**
 * Класс для работы с запросами к сервису ripe
 */
class RequestRipe
{
    static string $url='https://rest.db.ripe.net/search.json?query-string=';

    /**
     * Метод получения доп. данных по IP
     * @param $ip
     *
     * @return mixed
     */
    static function GetInfo($ip)
    {
        $httpClient = new HttpClient();
        $httpClient->query("GET", self::$url.$ip);
        return $httpClient->getResult();
    }
}