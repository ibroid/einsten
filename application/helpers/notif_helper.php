<?php

function notifToJurusita($data)
{
    $number = $data['number'];
    $text = $data['text'];
    $ch = curl_init('http://127.0.0.1/wa/send_message');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        // json_encode(['number' => $data['number'], 'text' => $data['text']])
        "{
            \"number\" : \"$number\",
            \"message\" : \"$text\",
            \"client_name\" : "default",
        }"
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
}
