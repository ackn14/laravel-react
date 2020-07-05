<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class t_mail_template extends Model
{
  protected $table = 't_mail_template';
  protected $guarded = [];
  public $timestamps = false;

  public static function getOfferTemplate()
  {
    $select = "*
                 ";

    $data = DB::table('t_mail_template as t')
      ->select(DB::raw($select))
      ->get();

    return $data;
  }
}
