<?php

// сторонняя библиотека Simple HTML DOM
include_once ('simple_html_dom.php');

function parse($input, $output)
{
    $doc = file_get_html($input);
    foreach($doc->find('tbody tr') as $row) {
        $cells = $row->find('td');
        $obj = [
            'name' => $cells[0]->innertext,
            'instruction' => strip_tags($cells[1]->innertext),
            'mnn' => $cells[2]->innertext,
            'dosageForm' => $cells[3]->innertext,
            'dosage' => $cells[4]->innertext,
            'packing' => $cells[5]->innertext,
            'manufacturerEnterprise' => $cells[6]->innertext,
            'countryOrigin' => $cells[7]->innertext,
            'certificateHolder' => $cells[8]->innertext,
            'countryCertificateHolder' => $cells[9]->innertext,
            'atx' => $cells[10]->innertext,
            'pharmaGroup' => $cells[11]->innertext,
            'essentialDrug' => $cells[12]->innertext,
            'conditionsFromPharma' => $cells[13]->innertext,
            'certificateNumber' => $cells[14]->innertext,
            'issueDate' => $cells[15]->innertext,
            'ean13' => $cells[16]->innertext
        ];

        // дописываем JSON в конец файла
        file_put_contents($output, json_encode($obj, JSON_UNESCAPED_UNICODE).', ', FILE_APPEND | LOCK_EX);
        unset($obj);
    }

    // очистка памяти
    $doc->clear();
    unset($doc);
}