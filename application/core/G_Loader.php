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

  /**
   * Load service
   * 
   * Method untuk meload service seperti meload library atau model
   * @param string $service_name Nama service yang ingin diload
   * @param array $params Parameter untuk service (opsional)
   * @param string $object_name Alias untuk instance service (opsional)
   * @return void
   */
  public function service($service_name, $params = NULL, $object_name = NULL)
  {
    if (!class_exists('G_Service')) {
      require_once(APPPATH . 'core/G_Service.php');
    }

    if (is_array($service_name)) {
      foreach ($service_name as $service) {
        $this->service($service);
      }
      return;
    }

    $service_class = ucfirst($service_name);

    if (file_exists(APPPATH . 'services/' . $service_class . '.php')) {
      require_once(APPPATH . 'services/' . $service_class . '.php');

      if ($params === NULL) {
        $service = new $service_class();
      } else {
        $service = new $service_class($params);
      }

      if ($object_name !== NULL) {
        $CI = &get_instance();
        $CI->$object_name = $service;
      } else {
        $CI = &get_instance();
        $CI->$service_name = $service;
      }
    } else {
      show_error('Unable to load the requested service: ' . $service_name);
    }
  }
}
