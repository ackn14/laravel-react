<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomMeeting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      $sql = "
DROP TABLE IF EXISTS `zoom_meeting`;
CREATE TABLE `zoom_meeting` (
  `room_id` int unsigned NOT NULL AUTO_INCREMENT,
  `zoom_meeting_id` bigint unsigned NOT NULL,
  `user_company_id` int unsigned NOT NULL,
  `worker_id` int unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `meeting_url` text,
  `interview_date` datetime DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`room_id`),
  KEY `user_company_id` (`user_company_id`),
  KEY `worker_id` (`worker_id`),
  CONSTRAINT `zoom_meeting_ibfk_1` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`),
  CONSTRAINT `zoom_meeting_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;";

      DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_meeting');
    }
}
