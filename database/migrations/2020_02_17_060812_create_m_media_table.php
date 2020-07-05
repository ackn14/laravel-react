<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMediaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('m_media', function (Blueprint $table) {
      $sql = "
    CREATE TABLE `m_media` (
        `media_id` varchar(50) NOT NULL DEFAULT '',
        `media_name` varchar(255) NOT NULL DEFAULT '',
        `url` varchar(255) NOT NULL DEFAULT '',
        `del_flag` tinyint(1) unsigned NOT NULL,
        PRIMARY KEY (`media_id`)
      ) ENGINE=InnoDB;
       ";

      DB::connection()->getPdo()->exec($sql);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('m_media');
  }
}
