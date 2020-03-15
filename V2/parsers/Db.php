<?php
namespace parsers;


class Db
{
    protected static $instance = null;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * Выполняется соединение с БД
     */
    protected function __construct()
    {
        $config = (defined('LOCAL') ? Config::getTestDbSettings() : Config::getDbSettings());
        //$config = Config::getTestDbSettings();
        $this->dbh = new \PDO($config['dsn'], $config['login'], $config['password'], $config['options']);
    }

    /**
     * Используется для запросов типа select
     * @param $sql
     * @param $class
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function query($sql, $class, $params = []) :array
    {
        $stmt = $this->dbh->prepare($sql);
        $res = $stmt->execute($params);
        if ($res === false) {
            throw new \Exception('DB ERROR IN QUERY METHOD OF CLASS DB');
        }
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->dbh->prepare($sql);
        $res = $stmt->execute($params);
        if ($res === false) {
            throw new \Exception('DB ERROR IN ' . __METHOD__ . ' METHOD OF CLASS DB');
        }
        return true;
    }
}