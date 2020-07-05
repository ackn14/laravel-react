<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerTimelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
DROP TABLE IF EXISTS `worker_timeline`;
CREATE TABLE `worker_timeline` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `worker_id` int unsigned NOT NULL,
  `user_company_id` int unsigned NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `del_flag` tinyint DEFAULT 0,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `worker_id` (`worker_id`),
  KEY `user_company_id` (`user_company_id`),
  CONSTRAINT `worker_timeline_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`),
  CONSTRAINT `worker_timeline_ibfk_2` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
        Schema::dropIfExists('worker_timeline');
    }
}
