<?php
include_once APPPATH . "models/Pengaturan.php";


function pengaturan()
{
    class Set
    {
        function __construct()
        {
            $data = Pengaturan::get();
            foreach ($data as $key => $value) {
                $sj = $value['key'];
                $this->$sj =  $value['value'];
            }
        }
    }
    return new Set();
}
