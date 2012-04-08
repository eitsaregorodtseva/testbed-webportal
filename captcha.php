<?php

session_start();

if (!empty($_POST['captcha'])) 
{
    if (empty($_SESSION['captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['captcha']) 
    {
        header('HTTP/1.1 403 Forbidden');
        exit();
    }
}
else
{
    header('HTTP/1.1 403 Forbidden');;
    exit();
}


$url = 'http://localhost/rest/users';
$method = 'POST';

# headers and data (this is API dependent, some uses XML)
$headers = array(
'Accept: application/json',
'Content-Type: application/json',
);

unset($_POST['captcha']);

//var_dump($_POST);

$data = json_encode($_POST);

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

switch($method)
{
    case 'GET':
    break;

    case 'POST':
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    break;

    case 'PUT':
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    break;

    case 'DELETE':
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
    break;
}

$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);


if($code == 200) {
    //
}
else
{
    echo $code . " - " . $response;
    header('HTTP/1.1 403 Forbidden');
    exit();
}