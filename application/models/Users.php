<?php
require_once APPPATH . 'models/Instrumens.php';
require_once APPPATH . 'models/Panitera.php';
class Users extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'users';
    protected $connection = 'local';

    public function instrumen()
    {
        return $this->hasMany(Instrumens::class, 'created_by', 'id')->orderBy('id', 'DESC');
    }

    public function profile()
    {
        return $this->setConnection('')->belongsTo(Panitera::class, 'profile_id', 'id');
    }
}
