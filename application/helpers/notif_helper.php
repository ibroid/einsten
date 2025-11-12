<?php

function notifToJurusita($data)
{
    $ch = curl_init('http://192.168.0.212:3000/api/send_message');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['number' => $data['number'], 'text' => $data['text']]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
}
