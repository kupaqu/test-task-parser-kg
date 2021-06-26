<?php

include_once('CurlRequest.php');
include_once('download.php');
set_time_limit(0);
ini_set('memory_limit', '256M');

$filename = date('Y-m-d-H-i-s') . '.json';

$myCurlRequest = new CurlRequest('C:\Users\Buda\PhpstormProjects\parse\\' . $filename);

// список стран https://namaztimes.kz/ru/api/country
$countries = json_decode(file_get_contents('countries.json'), true);

// получаем списки лекарств по каждой стране и записываем в файл $myCurlRequest->filename
foreach($countries as $country) {
    $myCurlRequest->putJSON(['proizvod' => $country]);
}

// отдаем файл на скачивание
// file_force_download($filename);
