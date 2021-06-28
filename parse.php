<?php

// сторонняя библиотека Simple HTML DOM
include_once ('simple_html_dom.php');

function parse($input, $output)
{
    $doc = file_get_html($input);
    foreach($doc->find('tbody tr') as $row) {
        $cells = $row->find('td');
        $obj = [
            'name' => trim($cells[0]->innertext ?? ''),
            'instruction' => trim(strip_tags($cells[1]->innertext ?? '')),
            'mnn' => trim($cells[2]->innertext ?? ''),
            'dosageForm' => trim($cells[3]->innertext ?? ''),
            'dosage' => trim($cells[4]->innertext ?? ''),
            'packing' => trim($cells[5]->innertext ?? ''),
            'manufacturerEnterprise' => trim($cells[6]->innertext ?? ''),
            'countryOrigin' => trim($cells[7]->innertext ?? ''),
            'certificateHolder' => trim($cells[8]->innertext ?? ''),
            'countryCertificateHolder' => trim($cells[9]->innertext ?? ''),
            'atx' => trim($cells[10]->innertext ?? ''),
            'pharmaGroup' => trim($cells[11]->innertext ?? ''),
            'essentialDrug' => trim($cells[12]->innertext ?? ''),
            'conditionsFromPharma' => trim($cells[13]->innertext ?? ''),
            'certificateNumber' => trim($cells[14]->innertext ?? ''),
            'issueDate' => trim($cells[15]->innertext ?? ''),
            'ean13' => trim($cells[16]->innertext ?? '')
        ];

        // дописываем JSON в конец файла
        file_put_contents($output, json_encode($obj, JSON_UNESCAPED_UNICODE) . ', ', FILE_APPEND | LOCK_EX);
        unset($obj);
    }

    // очистка памяти
    unlink($input);
    $doc->clear();
    unset($doc);
}