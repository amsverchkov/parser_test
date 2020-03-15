<?php
require_once dirname(__DIR__) . '/ini.php';
require_once dirname(__DIR__) . '/parsers/libs/PHPQuery.php';
require_once dirname(__DIR__) . '/autoload.php';

try {
    $controller = new \parsers\Controllers\CrossroadsController();
    $controller->grabData();
} catch (\Exception $e) {
    print '[' . date('Y-m-d H:i:s') . ']' . $e->getMessage() . ' TRACE: ' . $e->getTraceAsString() . PHP_EOL;
}
