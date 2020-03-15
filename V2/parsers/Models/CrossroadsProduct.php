<?php


namespace parsers\Models;


use parsers\Model;

class CrossroadsProduct extends Model
{
    /** @var string имя таблицы в БД */
    protected static $table = 'cross_products';

    /** @var int идентификатор записи */
    public $id;
    /** @var string наименование */
    public $title;
    /** @var string дата добавления */
    public $date_add;
    /** @var string имя файла-изображения */
    public $file_name;
    /** @var float акционная цена */
    public $stock_price;
    /** @var float обычная цена */
    public $regular_price;
    /** @var int идентифкаитор категории перекерстка */
    public $cross_category_id;
    /** @var int идентифкиатор категории на сайте при выводе*/
    public $site_category_id;
    /** @var int признак активности или неактивности продукта */
    public $status = 1;


    public function findOne()
    {

    }

    /**
     * @param string $name
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $date_add
     * @return $this
     */
    public function setDateAdd($date_add)
    {
        $this->date_add = $date_add;
        return $this;
    }

    /**
     * @param string $file_name
     * @return $this
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
        return $this;
    }

    /**
     * @param float $stock_price
     * @return $this
     */
    public function setStockPrice($stock_price)
    {
        $this->stock_price = $stock_price;
        return $this;
    }

    /**
     * @param float $regular_price
     * @return $this
     */
    public function setRegularPrice($regular_price)
    {
        $this->regular_price = $regular_price;
        return $this;
    }

    /**
     * @param int $cross_category_id
     * @return $this
     */
    public function setCrossCategoryId($cross_category_id)
    {
        $this->cross_category_id = $cross_category_id;
        return $this;
    }

    /**
     * @param int $site_category_id
     * @return $this
     */
    public function setSiteCategoryId($site_category_id)
    {
        $this->site_category_id = $site_category_id;
        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }


}