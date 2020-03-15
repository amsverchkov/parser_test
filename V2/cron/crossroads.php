<?php
require_once dirname(__DIR__) . '/ini.php';
require_once dirname(__DIR__) . '/parsers/libs/PHPQuery.php';
require_once dirname(__DIR__) . '/autoload.php';

try {
    $controller = new \parsers\Controllers\CrossroadsController();
    $controller->grabData();
} catch (\Exception $e) {
    print $e->getMessage();
}
