<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMessageDetailChangeColoumNameId extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('message_detail', function (Blueprint $table) {

      $sql = "
            
            ALTER TABLE `message_detail` CHANGE `id` `message_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, DROP PRIMARY KEY, ADD PRIMARY KEY (message_id);
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
    //
  }
}
