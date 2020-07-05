<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerInterviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
DROP TABLE IF EXISTS `worker_interview`;
CREATE TABLE `worker_interview` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `worker_id` int unsigned NOT NULL,
  `programming_language` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `desired_case_project` text,
  `ng_case_project` text,
  `desired_amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `minimum_amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `commuting_time` varchar(255) DEFAULT NULL,
  `operation` varchar(255) DEFAULT NULL,
  `operation_start_date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `operating_period` varchar(255) DEFAULT NULL,
  `priority_1st` text,
  `priority_2nd` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `priority_3rd` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `parallel_situation` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `del_flag` tinyint DEFAULT 0,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `worker_id` (`worker_id`),
  CONSTRAINT `worker_interview_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
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
        Schema::dropIfExists('worker_interview');
    }
}
