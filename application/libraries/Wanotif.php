<?php

class Wanotif
{
    private $base_url = "http://192.168.0.202:3030";
    private $session = "default";
    private $end_point = "/api/sendText";
    public $number = "0";
    public $text = "";

    public function __construct($params)
    {
        $this->number = $params['number'];
        $this->text = $params['text'];
    }

    function send()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->base_url . $this->end_point);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 400);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                "{
						\"chatId\" : \"$this->number\",
						\"text\" : \"$this->text\",
						\"session\" : \"$this->session\"
					}"
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
