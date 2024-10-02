<?php

if (!function_exists("vardie")) {
  function vardie(...$data)
  {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
  }
}
