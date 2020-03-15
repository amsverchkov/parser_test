<?php


namespace parsers;


class Config
{
    /** @var array массив с url-адресами для парсинга */
    protected static $urlsForParse = [
        'crossroads' => 'https://www.perekrestok.ru/catalog',
    ];

    /**
     * Возвращает url-ы для парсинга
     * @param string $source источник
     * @return string
     * @throws \Exception
     */
    public static function getUrlsForParse(string $source) :string
    {
        if (!isset(self::$urlsForParse[$source])) {
            throw new \Exception('UNDEFINED SOURCE IN CONFIG: ' . $source);
        }
        return self::$urlsForParse[$source];
    }

    /**
     * Возвращает массив настроек основной
     * рабочей БД
     * @return array
     */
    public static function getDbSettings(): array
    {
        return [
            'dsn' => 'mysql:host=db;dbname=qmag',
            'login' => 'root',
            'password' => '123',
            'options' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];
    }

    /**
     * Возвращает массив настроек
     * тестовой БД
     * @return array
     */
    public static function getTestDbSettings(): array
    {
        return [
            'dsn' => 'mysql:host=db;dbname=qmag',
            'login' => 'root',
            'password' => '123',
            'options' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];
    }
}