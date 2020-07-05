<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerSkill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_skill', function (Blueprint $table) {

            $sql = "
          CREATE TABLE `worker_skill` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `worker_id` INT(11) UNSIGNED NOT NULL,
            `skill_id` VARCHAR(11) NOT NULL,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE (`worker_id`, `skill_id`));
            
            ALTER TABLE `worker_skill`
            ADD CONSTRAINT `worker_id_worker_skill_referenced`
              FOREIGN KEY (`worker_id`)
              REFERENCES `worker` (`worker_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `skill_id_worker_skill_referenced`
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
