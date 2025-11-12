<?php

class Authentication
{
    public function __construct()
    {
        $these = &get_instance();
        foreach ($these->session->userdata() as $key => $value) {
            $this->$key = $value;
        }
    }
}

function auth()
{
    $auth = new Authentication();
    return $auth;
}
