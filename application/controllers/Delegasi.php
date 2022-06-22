<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "models/Instrumens.php";

class Delegasi extends CI_Controller
{
    public function index()
    {
        template('template', 'app/delegasi', [
            'data' => Instrumens::where('jurusita_id', 0)->latest()->get()
        ]);
    }
}
