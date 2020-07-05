<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectWorkingplace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_workingplace', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `project_workingplace` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `project_id` INT(11) UNSIGNED NOT NULL,
            `prefecture_id` VARCHAR(11) NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE (`project_id`, `prefecture_id`));
            
            ALTER TABLE `project_workingplace`
            ADD CONSTRAINT `project_id_project_workingplace_referenced`
              FOREIGN KEY (`project_id`)
              REFERENCES `project` (`project_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `prefecture_id_project_workingplace_referenced`
              FOREIGN KEY (`prefecture_id`)
              REFERENCES `m_prefecture` (`prefecture_id`)
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
