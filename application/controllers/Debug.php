<?php

require_once APPPATH . 'models/Instrumens.php';
class Debug extends CI_Controller
{
    public function index()
    {
        // echo password_hash('089636811489', PASSWORD_DEFAULT);
        echo generateRandomString();
    }

    public function create_user_pp()
    {
        $data = $this->capsule->table('jurusita')->where('aktif', 'Y')->get();
        foreach ($data as $key => $value) {
            $this->capsule->connection('local')->table('users')->insert([
                'username' => $value->keterangan,
                'password' => password_hash('paju', PASSWORD_DEFAULT),
                'profile_id' => $value->id,
                'level_id' => 7,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            echo $value->nama . '<br>';
        }
    }
    public function carbon()
    {
        echo carbon()->parse('2022-01-11')->isoFormat('dddd, D MMMM Y');
    }
}
