<?php
namespace parsers\Services;


use parsers\Models\CrossroadsCategories;

class CrossroadsParser
{
    /** Количество элементов на 1 странице Перекрестка */
    const ELEMS_ON_PAGE = 24;
    /** Промежуток перерыва между запросами */
    const AFTER_REQUEST_SLEEP = 2;

    /**
     * Получает старницу для разбора
     * @param string $url url страницы
     * @return string html-код страницы
     * @throws \Exception
     */
    public function getPage(string $url, $method = 'get', $params = []) :string
    {
        sleep(self::AFTER_REQUEST_SLEEP);
        $curl = new Curl();
        return $curl->getPage($url);
    }

    /**
     * Находит в html коде общее кол-во элментов,
     * возвращает количество старниц для парсинга.
     * @param string $startPage html-код старницы
     * @return int количество страниц
     */
    public function countPages(string $startPage): int
    {
        $dom = \PHPQuery::newDocument($startPage);
        $elementsCount = $dom->find('div.xf-sort__total span.js-list-total__total-count')->text();
        return ceil($elementsCount/self::ELEMS_ON_PAGE);
    }

    /**
     * Получает файл и сохранияет в локальной
     * директории.
     * @param string $imageWay
     * @return bool|string имя файла или ложь
     */
    protected function getImage($imageWay)
    {
        sleep(self::AFTER_REQUEST_SLEEP);

        $extension = substr($imageWay,mb_strrpos($imageWay,'.'));
        $fileName = md5($imageWay) . $extension;

        if (is_file($fileName)) {
            return $fileName;
        }

        if(copy($imageWay, IMAGES_WAY . '/' . $fileName)) {
            return $fileName;
        }

        return false;
    }

    /**
     * Возвращает массив с данным с разобранной
     * страницы.
     * @param string $page html-код страницы
     * @return array массив с данным со страницы
     * @throws \Exception
     */
    public function parsePage(string $page, CrossroadsCategories $category) :array
    {

        $pageJSON = json_decode($page, true);

        if ($pageJSON) {
            if (empty($pageJSON['html'])) {
                echo 'INVALID JSON IN ' . __METHOD__ . PHP_EOL;
                return [];
            }
            $page = $pageJSON['html'];
        }

        $rtnArr = [];

        $dom = \PHPQuery::newDocument($page);
        $infoDivs = $dom->find('div.xf-product');

        foreach ($infoDivs as $div) {
            $div = pq($div);

            $oldPrice = $div->find('div.xf-product-cost__prev')->attr('data-cost');

            if (!$oldPrice) {
                /**
                 * Забираем только лишь акционный товар, имеющий
                 * прежнюю стоимость.
                 */
                continue;
            }

            $tmp['regular_price'] = $oldPrice;
            $tmp['stock_price'] = $div->find('div.xf-product-cost__current')->attr('data-cost');
            $tmp['title'] = $div->find('a.xf-product-title__link')->attr('title');
            $fileName = $div->find('img.xf-product-picture__img')->attr('data-src');
            $tmp['file_name'] = $this->getImage($fileName);
            $date = new \DateTime();
            $tmp['date_add'] = $date->format('Y-m-d');
            $tmp['cross_category_id'] = $category->id;
            $tmp['site_category_id'] = $category->site_category_id;

            if ($tmp['file_name']) {
                $rtnArr[] = $tmp;
            }


        }

        return $rtnArr;

    }
}