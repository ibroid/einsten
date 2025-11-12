<?php

if (!class_exists('Authentication')) {
    class Authentication
    {
        public function __construct()
        {
            $these = &get_instance();
            foreach ($these->session->userdata('g_user_loged') as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}

if (!function_exists("auth")) {
    function auth()
    {
        $auth = new Authentication();
        return $auth;
    }
}
