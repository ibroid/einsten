<?php

class App extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!isset(auth()->login)) {
            redirect('auth');
        }
    }

    public function index()
    {
        switch (auth()->user->level_id) {
            case '4':
            case '5':
            case '6':
                template('template', 'app/panitera_pengganti');
                break;
            case '1':
            case '2':
            case '3':
                template('template', 'app/monitoring');
                break;
            default:
                template('template', 'app/jurusita');
                break;
        }
    }

    public function daftar()
    {
        template('template', 'app/daftar_instrumen', [
            'jurusita' => $this->capsule->table('jurusita')->where('aktif', 'Y')->get()
        ]);
    }
}
