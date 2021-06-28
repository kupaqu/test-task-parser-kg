<?php

include_once ('saveRemoteFile.php');
include_once ('parse.php');

set_time_limit(0);

// засекаем время
$start = microtime(true);

$url = 'http://212.112.103.101/reestr';
$json_filename = 'data.json';

// создаём папку, где будем хранить все скачанные html-файлы
$curdate = date('Y-m-d-H-i-s');
mkdir($curdate);

// открываем на запись файл логов
$log = fopen($curdate.'/logs.txt', 'w');

// загружаем список стран, по которому ведется поиск записей на сайте
$countries = json_decode(file_get_contents('countries.json'), true);

$cnt_countries = count($countries);

foreach($countries as $proizvod) {
    // скачиваем html-файл
    $response = saveRemoteFile($url, $curdate.'/'.$proizvod.'.html', 'proizvod='.$proizvod);

    // отслеживание успешности запроса
    fwrite($log, $proizvod.' response is '.$response.PHP_EOL);

    // парсим html-файл
    parse($curdate.'/'.$proizvod.'.html', $curdate.'/'.$json_filename);
    usleep(100000);
    echo 'a'; 
    ob_flush(); 
    flush();
}

fclose($log);

// echo 'Время выполнения парсинга: ' . round(microtime(true) - $start, 4) . ' сек.';
