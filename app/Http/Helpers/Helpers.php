<?php

function cant(): int
{
    return 15;
}

function id_wtp(): String
{
    $id = '2127';
    return $id;
}

function key_wtp(): String
{
    $key = "hdidhnrjrjrh7663i3jrid83uj38msoospdlsbe";
    return $key;
}

function base64($key, $type, $index = 0): String
{
    $limit = 2;
    if ($type == 'encode') {
        if ($index < $limit) {
            return base64(base64_encode($key), $type, $index + 1);
        }
    } else if ($type == 'decode') {
        if ($index < $limit) {
            return base64(base64_decode($key), $type, $index + 1);
        }
    } else {
        return new Exception('Incorrect parameters', 422);
    }
    return $key;
}

function msg_wtsp($telephone, $msg)
{
    $id = id_wtp();
    $key = key_wtp();

    $data = array('to' => $telephone, 'msg' => $msg);

    $url = "https://onyxberry.com/services/wapi/Client/sendMessage";
    $url = $url . '/' . $id . '/' . $key;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
}

/**
 * $type = "H:i" = 12 to 24
 * $type = "g:i a" = 24 to 12
 */
function hours_format($array, $type, $response = [], $index = 0): array
{
    if ($index < sizeof($array)) :
        array_push($response, date($type, strtotime($array[$index])));
        return hours_format($array, $type, $response, $index + 1);
    endif;

    return $response;
}

/**
 * $type = "H:i" = 12 to 24
 * $type = "g:i a" = 24 to 12
 */
function hours_format_single($hour, $type, $response = [], $index = 0)
{
    return date($type, strtotime($hour));
}
