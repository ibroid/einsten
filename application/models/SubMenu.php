<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubMenu extends Model
{
  protected $table = 'sub_menu';
  protected $fillable = [];

  public function menu()
  {
    return $this->belongsTo(Menu::class, 'menu_id', 'id');
  }
}
