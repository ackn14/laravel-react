<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSkill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_skill', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `project_skill` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `project_id` INT(11) UNSIGNED NOT NULL,
            `skill_id` VARCHAR(11) NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE (`project_id`, `skill_id`));

            ALTER TABLE `project_skill`
            ADD CONSTRAINT `project_id_project_skill_referenced`
              FOREIGN KEY (`project_id`)
              REFERENCES `project` (`project_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `skill_id_project_skill_referenced`
              FOREIGN KEY (`skill_id`)
              REFERENCES `m_skill` (`skill_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION;

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
