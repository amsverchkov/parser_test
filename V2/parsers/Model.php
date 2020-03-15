<?php
namespace parsers;

class Model
{
    /** @var int идентификтаор записи  */
    public $id;

    /**
     * Поля исключаемые из вставки
     * @var array
     */
    public static $excluded_fields = [
        'id' => 'id'
    ];

    /** @var string имя таблицы в БД */
    protected static $table = '';

    /**
     * Производит сохранение в БД
     */
    public function save() {
        $this->insert();
    }

    /**
     * Добавляет записи в БД
     * @throws \Exception
     */
    public function insert()
    {

        $fields = [];
        $placeHolders = [];

        foreach ($this as $prop => $value) {
            if (!isset(static::$excluded_fields[$prop])) {
                $fields[] = $prop . '=:' . $prop;
                $placeHolders[':' . $prop] = $value;
            }
        }
        $sql = 'INSERT INTO ' . static::$table . ' SET ' . implode(',', $fields) . ' ON DUPLICATE '
                . ' KEY UPDATE ' . implode(',', $fields);
        $db = Db::getInstance();
        $db->execute($sql, $placeHolders);
    }
}