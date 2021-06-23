<?php

include_once ('simple_html_dom.php');

class CurlRequest
{
    protected string $filename;
    protected string $url;

    public function __construct(string $filename, string $url = 'http://212.112.103.101/reestr') {
        $this->filename = $filename;
        $this->url = $url;
    }

    public function __destruct() {}

    // функция отдает на выход html в формате строки
    public function getDocument(array $post): bool|string
    {
        // устанавливаем параметры сеанса cURL
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; ry:38.0) Gecko/20100101 Firefox/38.0");
        curl_setopt($ch, CURLOPT_REFERER, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // получаем данные
        $stringHTML = curl_exec($ch);
        curl_close($ch);
        return $stringHTML;
    }

    // функция отдает на выход таблицу, которая преобразуется в JSON
    public function putJSON(array $post)
    {
        $stringHTML = $this->getDocument($post);
        $html = str_get_html($stringHTML);
        /*
         * вместо записи в массив $toJSON будем записывать сразу в файл,
         * т.к. массив занимает много оперативной памяти
         * */
        // $toJSON = array();
        foreach($html->find('tbody tr') as $row) {
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
            // array_push($toJSON, $obj);
            file_put_contents($this->filename,
                ', '.json_encode($obj, JSON_UNESCAPED_UNICODE), FILE_APPEND | LOCK_EX);
        }
        // return $toJSON;
    }

}