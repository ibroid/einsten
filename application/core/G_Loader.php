<?php
defined('BASEPATH') or exit('No direct script access allowed');

class G_Loader extends CI_Loader
{
  public $isTemplateDefined = false;

  public $template;

  public $data = [];

  public function template($template, $data = [])
  {
    $this->isTemplateDefined = true;

    $this->template = "layouts/$template";

    $this->data = $data;

    return $this;
  }

  public function page($pageName, $data = [])
  {
    $this->data["content"] = parent::view("pages/$pageName", $data, TRUE);
    if ($this->isTemplateDefined) {
      return parent::view($this->template, $this->data);
    }

    return parent::view($pageName, $data);
  }
}
