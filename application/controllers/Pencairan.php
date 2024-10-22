<?php

class Pencairan extends G_Controller
{
    public JurusitaService $jurusitaService;
    public InstrumenService $instrumenService;

    public function __construct()
    {
        parent::__construct();

        if ($this->userdata->name !== "Kasir") {
            redirect('/', 'refresh');
        }

        $this->load->service("JurusitaService", null, 'jurusitaService');
        $this->load->service("InstrumenService", null, 'instrumenService');
    }

    public function index()
    {
        $this->jurusita();
    }

    public function jurusita()
    {
        $this->load
            ->js_plugin([
                base_url('/assets/js/jquery.slim.js'),
                base_url(LocalResource::HTMX),
                base_url(LocalResource::SWEETALERT2)
            ])
            ->template("template", [
                "menus" => $this->get_user_menu(),
                "beranda_link" => $this->redirectPage[$this->userdata->name],
                "title" => "Keuangan"
            ])

            ->page("pencairan_jurusita_page", [
                "jurusita" => $this->jurusitaService->allActive(),
                "pencairan_hari_ini" => $this->instrumenService->dicairkanHariIni()
            ]);
    }

    public function daftar()
    {
        $this->load
            ->css_addon([base_url(LocalResource::DATATABLE_CSS)])
            ->js_plugin([
                base_url(LocalResource::JQUERY),
                base_url(LocalResource::DATATABLE_JS),
                base_url(LocalResource::HTMX),
                base_url(LocalResource::SWEETALERT2)
            ])
            ->template("template", [
                "menus" => $this->get_user_menu(),
                "beranda_link" => $this->redirectPage[$this->userdata->name],
                "title" => "Keuangan"
            ])
            ->page("daftar_pencairan_page");
    }

    public function datatable()
    {
        $this->instrumenService->pencairanDatatable();
    }
}
