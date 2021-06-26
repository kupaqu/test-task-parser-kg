<?php

// пример: saveRemoteFile('http://212.112.103.101/reestr', 'test_request.html' ,'proizvod=Италия');

function saveRemoteFile($url, $filename, $post)
{
    global $GlobalFileHandle;

    set_time_limit(0);

    // открываем файл на запись
    $GlobalFileHandle = fopen($filename, 'w+');

    // запрос cURL
    $ch = curl_init();

    // данные для поиска по сайту
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // настроим другие опции cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FILE, $GlobalFileHandle);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; ry:38.0) Gecko/20100101 Firefox/38.0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, -1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);

    // отключим проверку сертификатов
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // укажем функцию для записи в файл
    curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'curlWriteFile');

    // отправляем запрос, не присваивая переменной
    curl_exec($ch);

    // узнаем код ответа. понадобится для проверки успешности парсера
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // очистка ресурсов
    curl_close($ch);

    // закрываем поток глобального указателя на записываемый файл
    fclose($GlobalFileHandle);

    // echo $http_code;
    return $http_code;
}

// вспомогательная функция для непосредственной записи в файл
function curlWriteFile($cp, $data) { // что за аргумент $cp? почему-то без него, блять, не работает
    global $GlobalFileHandle;
    $len = fwrite($GlobalFileHandle, $data);
    return $len;
}
