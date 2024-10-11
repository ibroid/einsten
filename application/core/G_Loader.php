<?php
defined('BASEPATH') or exit('No direct script access allowed');

class G_Loader extends CI_Loader
{
  public $isTemplateDefined = false;

  public $template;

  public $data = [
    "css_addons" => [],
    "js_plugins" => []
  ];

  public function template($template, $data = [])
  {
    $this->isTemplateDefined = true;

    $this->template = "layouts/$template";

    $this->data = array_merge($this->data, $data);

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

  public function js_plugin($link)
  {
    $this->data['js_plugins'] = $link;
    return $this;
  }

  public function css_addon($link)
  {
    $this->data['css_addons'] = $link;
    return $this;
  }

  public function component($component, $vars = array(), $return = TRUE)
  {
    $component_path = APPPATH . 'components/' . $component . '.php';

    if (!file_exists($component_path)) {
      show_error("Unable to load the requested component file: $component_path");
    }

    return $this->_ci_load(array('_ci_path' => $component_path, '_ci_vars' => $vars, '_ci_return' => $return));
  }
}
