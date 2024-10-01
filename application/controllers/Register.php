<?php

use function PHPSTORM_META\map;

require_once APPPATH . 'models/Panitera.php';
require_once APPPATH . 'models/Jurusita.php';
require_once APPPATH . 'models/Users.php';

class Register extends CI_Controller
{
    public function index()
    {
        $this->load->view('auth/register', [
            'panitera' => Panitera::where('aktif', 'Y')->get(),
            'jurusita' => Jurusita::where('aktif', 'Y')->get()
        ]);
    }

    public function generate()
    {
        if ($this->input->method() != 'post') {
            http_response_code(404);
            exit;
        }
        try {
            //code...
            $user = Users::where('profile_id', $this->input->post('id'))->first();

            if ($user) {
                throw new Exception("Akun ini sudah tersedia. Silahkan login menggunakan nomor telepon", 1);
            }

            $pegawai = $this->input->post('jenis') == 6
                ? Panitera::find($this->input->post('id'))
                : Jurusita::find($this->input->post('id'));

            Users::create([
                'profile_id' => $this->input->post('id'),
                'password' => password_hash('paju', PASSWORD_BCRYPT),
                'username' => $pegawai->keterangan,
                'nama_lengkap' => $pegawai->nama_gelar,
                'level_id' => $this->input->post('jenis')
            ]);

            echo json_encode([
                'status' => 'Berhasil',
                'message' => 'Akun berhasil digenerate. Silahkan login menggunakan nomor telepon'
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => 'Terjadi Kesalahan',
                'message' => $th->getMessage()
            ]);
        }
    }
}
