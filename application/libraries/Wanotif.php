<?php

class Wanotif
{
    private $base_url = "http://127.0.0.1:8099";
    private $session = "default";
    private $end_point = "/wa/send_message";
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
						\"number\" : \"$this->number\",
						\"message\" : \"$this->text\",
						\"client_name\" : \"$this->session\"
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
