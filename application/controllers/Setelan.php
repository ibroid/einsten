<?php

require APPPATH . "models/Users.php";
class Setelan extends CI_Controller
{
    public function index()
    {
        template('template', 'app/pengaturan', [
            'user' => Users::find(auth()->user->id)->first()
        ]);
    }

    public function username()
    {
        $user = Users::find(auth()->user->id);

        $user->username = request('username');

        $user->save();

        redirect($_SERVER['HTTP_REFERER']);
    }
}
