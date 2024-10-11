<?php

trait HttpResponse
{
  public function response($data)
  {
    if (isset($_SERVER['HTTP_HX_REQUEST'])) {
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
