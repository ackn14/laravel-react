<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('message_room', function (Blueprint $table) {

      $sql = "
CREATE TABLE `message_room` ( `room_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '部屋ID' , `company_id` INT(11) UNSIGNED NOT NULL COMMENT '企業ID' , `worker_id` INT(11) UNSIGNED NOT NULL COMMENT '人材ID' , `user_company_id` INT(11) UNSIGNED COMMENT '担当者ID(ユーザ企業ID)' , `del_flag` TINYINT NOT NULL DEFAULT '0' , `create_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_date` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`room_id`))  ENGINE = InnoDB;
          ";

      DB::connection()->getPdo()->exec($sql);

      $table->foreign('company_id')->references('company_id')->on('company');
      $table->foreign('worker_id')->references('worker_id')->on('worker');
      $table->foreign('user_company_id')->references('user_company_id')->on('user_company');
      $table->unique(['company_id', 'worker_id', 'user_company_id']);
    });

    Schema::table('message_detail', function (Blueprint $table) {

      $sql = "
        CREATE TABLE `message_detail` ( `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , `room_id` INT(11) UNSIGNED NOT NULL , `sender_id` INT(11) UNSIGNED NOT NULL , `sender_type` VARCHAR(10) NOT NULL ,`message` TEXT NULL, `read_flag` TINYINT NOT NULL DEFAULT '0' , `del_flag` TINYINT NOT NULL DEFAULT '0' , `create_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `update_date` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
          ";


      DB::connection()->getPdo()->exec($sql);

      $table->foreign('room_id')->references('room_id')->on('message_room');
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
