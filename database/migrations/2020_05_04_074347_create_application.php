<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplication extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('application', function (Blueprint $table) {
      $sql = "
        CREATE TABLE `application` (
        `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
        `company_id` int unsigned NOT NULL COMMENT '企業ID',
        `worker_id` int unsigned NOT NULL COMMENT '人材ID',
        `joining_date` date DEFAULT NULL  COMMENT '入社予定日',
        `application_flag` tinyint NOT NULL DEFAULT '0',
        `del_flag` tinyint NOT NULL DEFAULT '0',
        `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `application_company_id_worker_id_unique` (`company_id`,`worker_id`),
        CONSTRAINT `application_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`),
        CONSTRAINT `application_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`)
      )
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
