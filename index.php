<?php

include_once('CurlRequest.php');
set_time_limit(0);

$myCurlRequest = new CurlRequest('C:\Users\Buda\PhpstormProjects\parse\\' . date('Y-m-d-H-i-s') . '.json');

// список стран https://namaztimes.kz/ru/api/country
$countries = json_decode(file_get_contents('countries.json'), true);

// получаем списки лекарств по каждой стране и записываем в файл $myCurlRequest->filename
foreach($countries as $country) {
    $myCurlRequest->putJSON(['proizvod' => $country]);
}