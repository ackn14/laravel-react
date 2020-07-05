<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProjectSkillPopularity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('t_project_skill_popularity', function (Blueprint $table) {
    
        $sql = "

          CREATE TABLE `t_project_skill_popularity` (
            `skill_id` VARCHAR(11) NOT NULL,
            `popularity` TINYINT(4) UNSIGNED NOT NULL,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`skill_id`),
            CONSTRAINT `skill_id_t_project_skill_popularity_referenced`
              FOREIGN KEY (`skill_id`)
              REFERENCES `m_skill` (`skill_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION
              );
              
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
