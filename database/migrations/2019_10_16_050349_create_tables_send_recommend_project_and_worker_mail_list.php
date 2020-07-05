<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesSendRecommendProjectAndWorkerMailList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
CREATE TABLE `send_recommend_project_mail` (
  `project_id` int(11) unsigned NOT NULL COMMENT '仕事ID',
  `send_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '送信フラグ',
  `send_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '送信日',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日',
  PRIMARY KEY (`project_id`,`create_date`),
  CONSTRAINT `send_recommend_project_mail_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`)
) ENGINE=InnoDB;

CREATE TABLE `send_recommend_worker_mail` (
  `worker_id` int(11) unsigned NOT NULL COMMENT '人材ID',
  `send_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '送信フラグ',
  `send_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '送信日',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日',
  PRIMARY KEY (`worker_id`,`create_date`),
  CONSTRAINT `send_recommend_worker_mail_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`)
) ENGINE=InnoDB;
          ";
      DB::connection()->getPdo()->exec($sql);
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
