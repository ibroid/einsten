<?php

use Illuminate\Database\Eloquent\Model;

class AccessableMenu extends Model
{
  protected  $table = "access_menu";
  protected $fillable = [];

  public function menu()
  {
    return $this->belongsTo(Menu::class, 'menu_id', 'id');
  }
}
