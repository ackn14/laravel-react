<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillNameIdentification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          $sql = "
            CREATE TABLE `skill_name_identification` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `skill_id` varchar(11) NOT NULL DEFAULT '',
              `skill_name` varchar(255) NOT NULL DEFAULT '',
              `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
              `update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `skill_id` (`skill_id`),
              CONSTRAINT `skill_name_identification_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `m_skill` (`skill_id`)
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
        Schema::dropIfExists('skill_name_identification');
    }
}
