<?php

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        template('auth', 'auth/login');
    }
    public function login()
    {
        if (isset($_POST['username'])) {
            $user = $this->capsule
                ->connection('local')
                ->table('users')
                ->where('username', request('username'))->first();

            if ($user) {
                if (password_verify(request('password'), $user->password)) {
                    $baseProfile = $this->getLevel($user->level_id);
                    $profile = $this->capsule
                        ->table($baseProfile)
                        ->where('id', $user->profile_id)->first();

                    $this->session->set_userdata([
                        'user' => $user,
                        'profile' => $profile,
                        'login' => true,
                    ]);

                    echo json_encode($profile);
                } else {
                    echo json_encode(null);
                }
            } else {
                echo json_encode($user);
            }
        }
    }
    private function getLevel($key)
    {
        switch ($key) {
            case '2':
            case '3':
                return 'hakim_pn';
                break;
            case '4':
            case '5':
            case '6':
                return 'panitera_pn';
                break;
            default:
                return 'jurusita';
                break;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
    }
}
