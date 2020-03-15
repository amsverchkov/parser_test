<?php
namespace parsers\Controllers;

use parsers\Config;
use parsers\Models\CrossroadsCategories;
use parsers\Models\CrossroadsProduct;
use parsers\Services\CrossroadsParser;

class CrossroadsController
{
    /**
     * Забирает данные с сайта-источника
     * и складывает в базу
     * @return bool
     * @throws \Exception
     */
    public function grabData(): bool
    {
        $parser = new CrossroadsParser();
        $baseParseUrl = Config::getUrlsForParse('crossroads');
        $categories = $this->getCategories();

        if (!empty($categories)) {
            foreach ($categories as $cat) {
                if ($cat->english_name) {
                    $parseUrl = $baseParseUrl . '/' . $cat->english_name . '/';
                    $startPage = $parser->getPage($parseUrl);
                    $pageCount = $parser->countPages($startPage);
                    $parsedArr = $parser->parsePage($startPage, $cat);
                    $this->saveData($parsedArr);
                    for ($i = 2; $i <= $pageCount; $i++) {
                        $page = $parser->getPage($parseUrl, 'get',
                            ['page' => $i, 'ajax' => true, 'sort' => 'rate_desc']
                        );
                        $parsedArr = $parser->parsePage($page, $cat);
                        $this->saveData($parsedArr);
                    }

                }
            }
        }
        return true;
    }

    /**
     * Сохраняет данные в БД
     * @param array $data данные для сохранения в БД
     * @return bool
     */
    protected function saveData(array $data): bool
    {
        if (!empty($data)) {
            foreach ($data as $item) {
                $model = new CrossroadsProduct();
                $model->setCrossCategoryId($item['cross_category_id'])
                        ->setDateAdd($item['date_add'])
                        ->setFileName($item['file_name'])
                        ->setRegularPrice($item['regular_price'])
                        ->setSiteCategoryId($item['site_category_id'])
                        ->setStockPrice($item['stock_price'])
                        ->setTitle($item['title']);
                $model->save();
            }
        }
        return true;
    }

    /**
     * Возвращает массив моделей категорий
     * @return CrossroadsCategories[]
     */
    protected function getCategories(): array
    {
        $model = new CrossroadsCategories();
        return $model->findAll();
    }
}