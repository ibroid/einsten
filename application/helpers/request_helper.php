<?php

class Request
{
    function __construct($req)
    {
        foreach ($req as $key => $value) {
            $this->$key = $value[$key];
        }
    }
}

function request($key = null)
{
    $these = &get_instance();
    if ($key == null) {
        return $these->input->post();
    }
    return $these->input->post($key, TRUE);
}
