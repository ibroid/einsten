<?php


class G_Input extends CI_Input
{
  public static function mustPost()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      show_404();
    }
  }

  public static function mustHtmx()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      show_404();
    }

    if (!isset($_SERVER['HTTP_HX_REQUEST']) || $_SERVER['HTTP_HX_REQUEST'] != true) {
      show_404();
    }
  }
}
