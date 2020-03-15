<?php

error_reporting(E_ALL);
//Определяет в дальнейшем тип подключения к БД
define('LOCAL', true);

//Путь к папке с изображениями, наполняемой парсером
define('IMAGES_WAY', dirname(__DIR__). '/images/parsers');