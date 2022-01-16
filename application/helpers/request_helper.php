<?php

class Request
{
    function __construct($req)
    {
        foreach ($req as $key => $value) {
            $this->$key = $value[$key];
        }
    }
}

function request($key = null)
{
    $these = &get_instance();
    if ($key == null) {
        return $these->input->post();
    }
    return $these->input->post($key, TRUE);
}

function download($name)
{

    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=\"" . basename($name) . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($name));
    ob_clean();
    flush();
    readfile($name); //showing the path to the server where the file is to be download
    exit;
}
