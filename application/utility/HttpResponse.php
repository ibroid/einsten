<?php

trait HttpResponse
{
  public function response($data)
  {
    if (isset($_SERVER['HX-Request'])) {
      set_status_header(200);
      echo $data;
      return;
    }

    if ($_SERVER['HTTP_ACCEPT'] == "application/json") {
      set_status_header(200);
      header("Content-Type : application/json");
      echo json_encode($data);
      return;
    }

    redirect($data);
  }
}
