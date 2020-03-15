<?php


namespace parsers\Models;


use parsers\Db;

class CrossroadsCategories
{
    /** @var string имя таблицы в БД */
    protected static $table = 'cross_categories';

    /** @var int идентификатор записи */
    public $id;
    /** @var string наименование категории */
    public $name;
    /** @var string английское наименование */
    public $english_name;
    /** @var int идентификатор категории на сайте Перекерстка */
    public $source_category_id;
    /** @var int идентифкаитор категории на сайте при выводе */
    public $site_category_id;

    /**
     * Возвращает массив со всеми категориями
     * @return array
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM ' . static::$table;
        return $db->query($sql, static::class);
    }


}