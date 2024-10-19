<?php

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = "menu";
  protected $fillable = [];

  public function sub_menu()
  {
    return $this->hasMany(SubMenu::class, 'menu_id', 'id');
  }
}
